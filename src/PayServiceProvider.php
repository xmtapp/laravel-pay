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
use XmtApp\Payment\Alipay\Alipay;


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

        $this->app->singleton(Alipay::class, function () {
            $aop = new Alipay();
            $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';

            $config = config('laravel-pay.alipay');
            if ($config['sandbox_enabled'] == true) {
                $aop->gatewayUrl                = 'https://openapi.alipaydev.com/gateway.do';
                $config['appid']                = $config['sandbox']['appid'];
                $config['app_private_key']      = $config['sandbox']['app_private_key'];
                $config['alipay_public_key']    = $config['sandbox']['alipay_public_key'];
                $config['seller_id']    = $config['sandbox']['seller_id'];
            }

            $aop->appId                 = $config['appid'];
            $aop->rsaPrivateKeyFilePath = $config['app_private_key'];
            $aop->alipayPublicKey       = $config['alipay_public_key'];
            $aop->apiVersion            = $config['api_version'];
            $aop->signType              = $config['sign_type'];
            $aop->postCharset           = $config['charset'];
            $aop->format                = $config['format'];
            $aop->seller_id             = $config['seller_id'];

            return $aop;
        });

        $this->app->bind(
            'XmtApp\Payment\Contracts\Notify',
            'XmtApp\Payment\Alipay\HandleNotify'
        );
    }


    protected function setPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-pay.php' => config_path('laravel-pay.php')
        ], 'laravel-pay');
    }


}