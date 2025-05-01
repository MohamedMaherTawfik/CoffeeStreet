<?php

namespace App\Providers;

use App\Http\interface\ProductInteface;
use App\Http\Repository\ProductRepository;
use App\Interfaces\cartInterface;
use App\services\CartServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInteface::class, ProductRepository::class);
        // $this->app->bind(cartInterface::class, CartServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
