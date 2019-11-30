<?php

namespace App\Providers;
use Validator;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //扩展身份证验证规则
        Validator::extend('identitycards', function($attribute, $value, $parameters) {
            return preg_match('/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}$)/', $value);
        });
        Validator::extend('telphone', function($attribute, $value, $parameters) {
            return preg_match('/^1[34578][0-9]{9}$/', $value);
        });
       
        Validator::extend('strnumber', function($attribute, $value, $parameters) {
            return preg_match('/^[ACDEFGHJKLMNPQRSTUVWXY345679]{2}$/', $value);
        });

        Schema::defaultStringLength(191);
        //左侧菜单
        view()->composer('admin.layout',function($view){
            $menus = \App\Models\Permission::with([
                'childs'=>function($query){$query->with('icon');}
                ,'icon'])->where('parent_id',0)->orderBy('sort','desc')->get();
            $unreadMessage = \App\Models\Message::where('read',1)->where('accept_uuid',auth()->user()->uuid)->count();
            $view->with('menus',$menus);
            $view->with('unreadMessage',$unreadMessage);
        });
        error_reporting(E_ALL ^ E_NOTICE);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
