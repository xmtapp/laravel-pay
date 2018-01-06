<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2018/1/6
 * Time: 上午11:44
 */

namespace XmtApp\Payment\Alipay\Facades;


use Illuminate\Support\Facades\Facade;

class AopClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AopClient::class;
    }
}