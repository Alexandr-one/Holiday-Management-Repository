<?php

namespace App\Providers;

use App\Classes\ControlOrganizationEnum;
use App\Organization;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \Illuminate\Support\Facades\View::composer('index', function($view) {
            $view->with(['organization' => Organization::findorfail(ControlOrganizationEnum::ID)]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
