<?php

namespace App\Services\Contracts;

use App\Models\MediaAsset;

interface MediaServiceInterface
{
    /**
     * Data minimal: product_id, type, is_cover?, sort_order?, url? atau file? (UploadedFile)
     * Akan meng-set is_cover lain menjadi false jika is_cover=true.
     */
    public function attachToProduct(array $data): MediaAsset;

    public function delete(MediaAsset $media): void;
}
