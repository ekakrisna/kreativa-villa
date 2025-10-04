<?php

namespace App\Services\Pricing;

use App\Models\SeasonalPricing;
use App\Models\Product;
use App\Services\Contracts\SeasonalPricingServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SeasonalPricingService implements SeasonalPricingServiceInterface
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $q = SeasonalPricing::query()
            ->when($filters['product_id'] ?? null, fn($x, $v) => $x->where('product_id', $v))
            ->when(($filters['date_from'] ?? null) && ($filters['date_to'] ?? null), function ($x) use ($filters) {
                $from = $filters['date_from'];
                $to = $filters['date_to'];
                $x->where(function ($q) use ($from, $to) {
                    $q->whereBetween('start_date', [$from, $to])
                        ->orWhereBetween('end_date', [$from, $to])
                        ->orWhere(function ($qq) use ($from, $to) {
                            $qq->where('start_date', '<=', $from)->where('end_date', '>=', $to);
                        });
                });
            })
            ->with('product:id,title,type,rate_unit')
            ->orderByDesc('start_date');

        return $q->paginate($filters['per_page'] ?? 15);
    }

    public function create(array $data): SeasonalPricing
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            // default rate_unit ikut product jika tidak diisi
            $data['rate_unit'] = $data['rate_unit'] ?? $product->rate_unit;

            $this->assertNoOverlap($data['product_id'], $data['start_date'], $data['end_date'], null);

            /** @var SeasonalPricing $season */
            $season = SeasonalPricing::create([
                'product_id'       => $data['product_id'],
                'start_date'       => $data['start_date'],
                'end_date'         => $data['end_date'],
                'rate'             => $data['rate'],
                'rate_unit'        => $data['rate_unit'],
                'min_nights'       => $data['min_nights'] ?? null,
                'min_days'         => $data['min_days'] ?? null,
                'day_of_week_mask' => $data['day_of_week_mask'] ?? null,
                'name'             => $data['name'] ?? null,
            ]);

            return $season->fresh();
        });
    }

    public function update(SeasonalPricing $season, array $data): SeasonalPricing
    {
        return DB::transaction(function () use ($season, $data) {
            $start = $data['start_date'] ?? $season->start_date;
            $end   = $data['end_date']   ?? $season->end_date;

            $this->assertNoOverlap($season->product_id, $start, $end, $season->id);

            $season->update([
                'start_date'       => $start,
                'end_date'         => $end,
                'rate'             => $data['rate'] ?? $season->rate,
                'rate_unit'        => $data['rate_unit'] ?? $season->rate_unit,
                'min_nights'       => $data['min_nights'] ?? $season->min_nights,
                'min_days'         => $data['min_days'] ?? $season->min_days,
                'day_of_week_mask' => $data['day_of_week_mask'] ?? $season->day_of_week_mask,
                'name'             => $data['name'] ?? $season->name,
            ]);

            return $season->fresh();
        });
    }

    public function delete(SeasonalPricing $season): void
    {
        $season->delete();
    }

    private function assertNoOverlap(int $productId, string $start, string $end, ?int $exceptId): void
    {
        $exists = SeasonalPricing::query()
            ->where('product_id', $productId)
            ->when($exceptId, fn($x) => $x->where('id', '!=', $exceptId))
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($qq) use ($start, $end) {
                        $qq->where('start_date', '<=', $start)->where('end_date', '>=', $end);
                    });
            })
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'start_date' => ['Season overlaps with existing record.'],
                'end_date'   => ['Season overlaps with existing record.'],
            ]);
        }
    }
}
