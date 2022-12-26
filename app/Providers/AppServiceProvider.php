<?php

namespace App\Providers;

use App\SocialMedia;
use App\System;
use App\TremsAndCondition;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {
            $params['system'] = System::first();
            $view->with($params);
        });
        view()->composer('frontEnd.include.footer', function ($view) {
            $params['social_medias'] = SocialMedia::where("publication_status", true)->get();
            $footer = TremsAndCondition::where("type", "Footer")->first();            
            $params["footer_text"] = $footer->trems_and_condition ?? "";
            $footer = TremsAndCondition::where("type", "Footer_CopyRight")->first();      
            $params["copy_right"] = $footer->trems_and_condition ?? "";      
            $view->with($params);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
