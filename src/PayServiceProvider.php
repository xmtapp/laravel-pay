<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 上午11:49
 */

namespace XmtApp\Payment;

use Illuminate\Support\ServiceProvider;


class PayServiceProvider extends  ServiceProvider
{

    /**
     * 在注册后进行服务的启动
     *
     * @return void
     */
    public function boot()
    {
        $this->setPublishes();

        $this->mergeConfigFrom(__DIR__.'/../config/laravel-pay.php', 'laravel-pay');
    }


    protected function setPublishes()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-pay.php' => config_path('laravel-pay.php')
        ], 'laravel-pay');
    }

}