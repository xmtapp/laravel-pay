<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/14
 * Time: 上午10:41
 */

namespace XmtApp\Payment\Alipay\Facades;

use Illuminate\Support\Facades\Facade;

class AuthAlipay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alipay-auth';
    }
}