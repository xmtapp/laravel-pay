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
        if ($this->isAlipayBrowser($request) && !$this->needReauth()) {
            if ($request->has('auth_code')) {
                $tokens = AuthAlipay::getAccessToken($request->auth_code);

                if (!empty($tokens)) {
                    $user_info = AuthAlipay::userInfo($tokens->access_token);

                    session(['alipay.user_info' => $user_info]);
                }

                return redirect()->to($this->getTargetUrl($request));
            }

            session()->forget('alipay.user_info');

            // 获取授权链接
            return redirect()->to(AuthAlipay::getAuthRedirectUrl($request->fullUrl()));
        }

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['app_id', 'source', 'scope', 'auth_code']);

        return $request->url().(empty($queries) ? '' : '?'.http_build_query($queries));
    }

    /**
     * 判断是否需要重新授权
     * @return bool
     */
    private function needReauth()
    {
        $user_info = session('alipay.user_info');

        return empty($user_info) ? false : true;
    }

    /**
     * 判断是否支付宝扫码
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isAlipayBrowser($request)
    {
        return strpos(strtolower($request->header('user_agent')), 'alipayclient') !== false;
    }
}