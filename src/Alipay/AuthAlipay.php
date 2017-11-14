<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午6:01
 */

namespace XmtApp\Payment\Alipay;


class AuthAlipay
{
    const AUTH_API_URL = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';


    /**
     * 获取用户授权地址
     * @param string $redirect_uri
     * @return string
     */
    public function getAuthRedirectUrl(string $redirect_uri)
    {
        $appid = config('laravel-pay.alipay.appid');

        $scope = config('laravel-pay.alipay.auth_scope');

        $uri = self::AUTH_API_URL . '?app_id=' . $appid . '&scope=' . $scope . '&redirect_uri=' . urlencode($redirect_uri);

        return $uri;
    }
}