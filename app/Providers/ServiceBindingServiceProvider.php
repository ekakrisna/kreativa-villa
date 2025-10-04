<?php

namespace App\Providers;

use App\Services\Catalog\ProductQueryService;
use App\Services\Categories\CategoryService;
use App\Services\Contracts\AvailabilityBlockServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\MediaServiceInterface;
use App\Services\Contracts\ProductQueryServiceInterface;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\ProductUnitServiceInterface;
use App\Services\Contracts\SeasonalPricingServiceInterface;
use App\Services\Media\MediaService;
use App\Services\Pricing\AvailabilityBlockService;
use App\Services\Pricing\SeasonalPricingService;
use App\Services\Products\ProductService;
use App\Services\Products\ProductUnitService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductQueryServiceInterface::class, ProductQueryService::class);
        $this->app->bind(ProductUnitServiceInterface::class, ProductUnitService::class);
        $this->app->bind(MediaServiceInterface::class, MediaService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(SeasonalPricingServiceInterface::class, SeasonalPricingService::class);
        $this->app->bind(AvailabilityBlockServiceInterface::class, AvailabilityBlockService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
