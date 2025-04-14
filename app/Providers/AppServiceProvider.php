<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Modules\ProjectManagementRepository;
use App\Repositories\Product\ProductRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     //$this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


    public function register()
    {
        $this->app->bind(\App\Repositories\FileRepository::class, function ($app) {
            return new \App\Repositories\FileRepository();
        });

        $this->app->bind(\App\Services\FileService::class, function ($app) {
            return new \App\Services\FileService(
                $app->make(\App\Repositories\FileRepository::class)
            );
        });
    }
}
