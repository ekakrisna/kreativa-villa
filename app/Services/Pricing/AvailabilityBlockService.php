<?php

namespace App\Services\Pricing;

use App\Models\AvailabilityBlock;
use App\Services\Contracts\AvailabilityBlockServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AvailabilityBlockService implements AvailabilityBlockServiceInterface
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $q = AvailabilityBlock::query()
            ->when($filters['product_id'] ?? null, fn($x, $v) => $x->where('product_id', $v))
            ->when($filters['product_unit_id'] ?? null, fn($x, $v) => $x->where('product_unit_id', $v))
            ->when($filters['type'] ?? null, fn($x, $v) => $x->where('type', $v))
            ->when(($filters['date_from'] ?? null) && ($filters['date_to'] ?? null), function ($x) use ($filters) {
                $from = $filters['date_from'];
                $to = $filters['date_to'];
                $x->where(function ($q) use ($from, $to) {
                    $q->whereBetween('start_datetime', [$from, $to])
                        ->orWhereBetween('end_datetime', [$from, $to])
                        ->orWhere(function ($qq) use ($from, $to) {
                            $qq->where('start_datetime', '<=', $from)->where('end_datetime', '>=', $to);
                        });
                });
            })
            ->orderByDesc('start_datetime');

        return $q->paginate($filters['per_page'] ?? 15);
    }

    public function create(array $data): AvailabilityBlock
    {
        return DB::transaction(function () use ($data) {
            $this->assertValidRange($data['start_datetime'], $data['end_datetime']);

            /** @var AvailabilityBlock $block */
            $block = AvailabilityBlock::create([
                'product_id'      => $data['product_id'],
                'product_unit_id' => $data['product_unit_id'] ?? null,
                'type'            => $data['type'],
                'start_datetime'  => $data['start_datetime'],
                'end_datetime'    => $data['end_datetime'],
                'note'            => $data['note'] ?? null,
                'created_by'      => Auth::user()->id,
            ]);

            return $block->fresh();
        });
    }

    public function update(AvailabilityBlock $block, array $data): AvailabilityBlock
    {
        return DB::transaction(function () use ($block, $data) {
            $start = $data['start_datetime'] ?? $block->start_datetime;
            $end   = $data['end_datetime']   ?? $block->end_datetime;

            $this->assertValidRange($start, $end);

            $block->update([
                'product_id'      => $data['product_id']      ?? $block->product_id,
                'product_unit_id' => $data['product_unit_id'] ?? $block->product_unit_id,
                'type'            => $data['type']            ?? $block->type,
                'start_datetime'  => $start,
                'end_datetime'    => $end,
                'note'            => $data['note']            ?? $block->note,
            ]);

            return $block->fresh();
        });
    }

    public function delete(AvailabilityBlock $block): void
    {
        $block->delete();
    }

    private function assertValidRange(string $start, string $end): void
    {
        if (strtotime($end) <= strtotime($start)) {
            throw ValidationException::withMessages([
                'end_datetime' => ['End must be after start.'],
            ]);
        }
    }
}
