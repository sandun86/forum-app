<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Validation rule for checking if any scripts inserted in input field
        Validator::extend('script_tags_free', function ($attribute, $value, $parameters, $validator) {
            $originalValue = $value;
            $value = strip_tags($value);

            if (strlen($originalValue) == strlen($value)) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\v1\NotifyRepositoryInterface',
            'App\Repositories\v1\NotifyRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\v1\UserRepositoryInterface',
            'App\Repositories\v1\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\v1\PostRepositoryInterface',
            'App\Repositories\v1\PostRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\v1\AdminUserRepositoryInterface',
            'App\Repositories\v1\AdminUserRepository'
        );

    }
}
