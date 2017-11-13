<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午2:30
 */

namespace XmtApp\Payment\Alipay\Middleware;

use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}