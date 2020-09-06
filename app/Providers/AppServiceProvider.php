<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);

        // Extends the validator
        Validator::extendImplicit(
            'empty_if',
            function ($attribute, $value, $parameters, $validator) {
                $data = request()->input($parameters[0]);
                $parameters_values = array_slice($parameters, 1);
                foreach ($parameters_values as $parameter_value) {
                    if ($data == $parameter_value && !empty($value)) {
                        return false;
                    }
                }
                return true;
            }
        );

        // (optional) Display error replacement
        Validator::replacer(
            'empty_if',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace(
                    [':other', ':value'],
                    [$parameters[0], request()->input($parameters[0])],
                    $message
                );
            }
        );
    }
}
