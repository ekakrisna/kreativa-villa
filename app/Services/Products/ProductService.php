<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\ProductVilla;
use App\Models\ProductVehicle;
use App\Models\ProductHelmet;
use App\Models\ProductTour;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService implements ProductServiceInterface
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
            }

            /** @var Product $product */
            $product = Product::create(Arr::except($data, ['categories', 'units', 'details']));

            // categories (opsional)
            if (!empty($data['categories']) && is_array($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            // details per type (opsional)
            $this->upsertTypeDetail($product, $data['details'] ?? []);

            return $product->fresh(['categories', 'villa', 'vehicle', 'helmet', 'tour']);
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update(Arr::except($data, ['categories', 'details']));

            if (array_key_exists('categories', $data)) {
                $product->categories()->sync($data['categories'] ?? []);
            }

            if (array_key_exists('details', $data)) {
                $this->upsertTypeDetail($product, $data['details'] ?? []);
            }

            return $product->fresh(['categories', 'villa', 'vehicle', 'helmet', 'tour']);
        });
    }

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $product->categories()->detach();
            $product->delete();
        });
    }

    private function upsertTypeDetail(Product $product, array $details): void
    {
        switch ($product->type) {
            case 'villa':
                ProductVilla::updateOrCreate(['product_id' => $product->id], $details);
                break;
            case 'motor':
            case 'car':
                $details['vehicle_type'] = $product->type;
                ProductVehicle::updateOrCreate(['product_id' => $product->id], $details);
                break;
            case 'helmet':
                ProductHelmet::updateOrCreate(['product_id' => $product->id], $details);
                break;
            case 'tour':
                ProductTour::updateOrCreate(['product_id' => $product->id], $details);
                break;
        }
    }
}
