<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午2:30
 */

namespace XmtApp\Payment\Alipay\Middleware;

use Closure;
use Illuminate\Http\Request;
use XmtApp\Payment\Alipay\Facades\AuthAlipay;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($this->isAlipayClient($request)) {
            // 获取授权链接
            $uri = AuthAlipay::getAuthRedirectUrl($request->getUri());

            return redirect($uri);
        }

        return $next($request);
    }


    /**
     * 判断是否支付宝扫码
     * @param $request
     * @return bool
     */
    protected function isAlipayClient(Request $request)
    {
        $userAgent = strtolower($request->header('user-agent'));

        if (strpos($userAgent, 'alipayclient') != false) {
            return true;
        }

        return false;
    }
}