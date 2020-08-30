<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        //
        // DB::listen(function ($query) {
        //     echo $query->sql . "\n";
        //     //$query->sql
        //     print_r($query->bindings);
        //     // $query->time
        // });
    }
}
