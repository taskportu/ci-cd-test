<?php

namespace App\Providers;

use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Session;

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
    public function boot(Request $request)
    {
        //
        Schema::defaultStringLength(191);
        if (Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 60 ))
        {

            Session::forget('otp_send');
        }
        else
        {

            Session::get('otp_send');
        }

        Blade::if('checkaccess', function ($permission, $permissions_list) {
            if(in_array($permission, $permissions_list)) :
                return true;
            endif;
        });


    }
}
