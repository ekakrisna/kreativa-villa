<?php

namespace App\Services\Media;

use App\Models\MediaAsset;
use App\Services\Contracts\MediaServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaService implements MediaServiceInterface
{
    public function attachToProduct(array $data): MediaAsset
    {
        return DB::transaction(function () use ($data) {
            $pathOrUrl = $data['url'] ?? null;

            // dukung upload file
            if (!$pathOrUrl && isset($data['file']) && $data['file'] instanceof UploadedFile) {
                $pathOrUrl = Storage::disk('public')->putFile('products', $data['file']);
                $pathOrUrl = Storage::disk('public')->url($pathOrUrl);
            }

            /** @var MediaAsset $asset */
            $asset = MediaAsset::create([
                'product_id' => $data['product_id'],
                'url'        => $pathOrUrl,
                'type'       => $data['type'] ?? 'image',
                'is_cover'   => (bool)($data['is_cover'] ?? false),
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'meta'       => $data['meta'] ?? null,
            ]);

            if ($asset->is_cover) {
                MediaAsset::where('product_id', $asset->product_id)
                    ->where('id', '!=', $asset->id)
                    ->update(['is_cover' => false]);
            }

            return $asset->fresh();
        });
    }

    public function delete(MediaAsset $media): void
    {
        // jika file di public storage (opsional hapus fisik)
        if ($media->url && str_contains($media->url, '/storage/')) {
            $rel = str_replace('/storage/', '', parse_url($media->url, PHP_URL_PATH));
            Storage::disk('public')->delete($rel);
        }
        $media->delete();
    }
}
