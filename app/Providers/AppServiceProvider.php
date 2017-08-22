<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Customers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Customers::setStripeKey('sk_test_WeCDqhEXuKeafssw5IW2BEOR');
        $this->app->bind('App\ServicesRepo\Contracts\PayMethodsRepositoryInterface', 'App\ServicesRepo\PayMethodsRepository');
        $this->app->bind('App\ServicesRepo\Contracts\UploadFileRepositoryInterface', 'App\ServicesRepo\UploadFileRepository');
    }
}
