<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductsRepositoryContract;
use App\Repositories\ProductsRepository;
use App\Services\Contract\FileStorageServiceContract;
use App\Services\FileStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductsRepositoryContract::class, ProductsRepository::class);
        $this->app->bind(FileStorageServiceContract::class, FileStorageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
