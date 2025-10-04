<?php

namespace App\Http\Controllers\Api\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Media\StoreMediaRequest;
use App\Models\MediaAsset;
use App\Services\Contracts\MediaServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use ApiResponse;

    public function __construct(private MediaServiceInterface $media) {}

    // POST /admin/media
    public function store(StoreMediaRequest $request)
    {
        // Request mendukung either 'file' upload atau 'url' langsung.
        $asset = $this->media->attachToProduct($request->validated());
        return $this->successResponse($asset, 'Media added', 201);
    }

    // DELETE /admin/media/{media_asset}
    public function destroy(MediaAsset $media)
    {
        $this->media->delete($media);
        return $this->successResponse(null, 'Media removed');
    }
}
