<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 上午11:49
 */

namespace XmtApp\Payment;

use Illuminate\Support\ServiceProvider;
use XmtApp\Payment\Alipay\AuthAlipay;


class PayServiceProvider extends  ServiceProvider
{

    /**
     * 在注册后进行服务的启动
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-pay.php', 'laravel-pay');

        $this->setPublishes();
    }


    /**
     * 在容器中注册绑定
     */
    public function register()
    {
        $this->app->singleton('alipay-auth', function () {
            return new AuthAlipay();
        });
    }


    protected function setPublishes()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-pay.php' => config_path('laravel-pay.php')
        ], 'laravel-pay');
    }


}