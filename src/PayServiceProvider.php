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


class PayServiceProvider extends ServiceProvider
{

    /**
     * 在注册后进行服务的启动
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-pay.php', 'laravel-pay');

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

        $this->app->singleton('\AopClient', function () {
            $aop = new \AopClient();

            $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
            $aop->appId = config('laravel-pay.alipay.appid');
            $aop->rsaPrivateKey = config('laravel-pay.alipay.private_key');
            $aop->alipayrsaPublicKey = config('laravel-pay.alipay.public_key');
            $aop->apiVersion = config('laravel-pay.alipay.api_version');
            $aop->signType = config('laravel-pay.alipay.sign_type');
            $aop->postCharset = config('laravel-pay.alipay.charset');
            $aop->format = config('laravel-pay.alipay.format');

            return $aop;
        });
    }


    protected function setPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-pay.php' => config_path('laravel-pay.php')
        ], 'laravel-pay');
    }


}