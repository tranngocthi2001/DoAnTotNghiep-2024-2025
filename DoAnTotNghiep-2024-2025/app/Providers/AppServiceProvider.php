<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('admin', function ($attribute, $value, $parameters, $validator) {
            // Logic kiểm tra cho rule 'admin' của bạn
            return $value === 'admin'; // Ví dụ: chỉ cho phép giá trị là 'admin'
        });
    }
}
