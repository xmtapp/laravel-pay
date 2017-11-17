<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午6:01
 */

namespace XmtApp\Payment\Alipay;

use AlipaySystemOauthTokenRequest;
use AlipayUserInfoShareRequest;

class AuthAlipay
{
    const AUTH_API_URL = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
    const AUTH_API_SANDBOX_URL = 'https://openauth.alipaydev.com/oauth2/publicAppAuthorize.htm';

    /**
     * 获取用户授权地址
     * @param string $redirect_uri
     * @return string
     */
    public function getAuthRedirectUrl(string $redirect_uri)
    {
        $config = config('laravel-pay.alipay');

        if ($config['sandbox_enabled'] == true) {
            $uri = self::AUTH_API_SANDBOX_URL . '?app_id=' . $config['sandbox']['appid'] . '&scope=' . $config['auth_scope'] . '&redirect_uri=' . urlencode($redirect_uri);
        } else {
            $uri = self::AUTH_API_URL . '?app_id=' . $config['appid'] . '&scope=' . $config['auth_scope'] . '&redirect_uri=' . urlencode($redirect_uri);
        }

        return $uri;
    }


    /**
     * 获取accessToken
     * @param string $code
     * @return mixed
     */
    public function getAccessToken(string $code)
    {
        $aop = resolve('\AopClient');

        $aop->format = 'json'; // 仅支持json格式

        $request = new AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($code);
        $result = $aop->execute($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if (isset($result->{$responseNode}->user_id) && isset($result->{$responseNode}->access_token)) {
            return $result->{$responseNode};
        }

        return [];
    }

    /**
     * 获取登录用户的信息
     * @param string $access_token
     * @return array
     */
    public function userInfo(string $access_token)
    {
        $aop = resolve('\AopClient');

        $aop->format = 'json'; // 仅支持json格式

        $request = new AlipayUserInfoShareRequest();
        $result = $aop->execute($request, $access_token);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if (isset($result->{$responseNode}->user_id)) {
            $attributes = [
                'id' => $result->{$responseNode}->user_id,
                'nickname' => $result->{$responseNode}->nick_name,
                'avatar' => $result->{$responseNode}->avatar,
                'province' => $result->{$responseNode}->province,
                'city' => $result->{$responseNode}->city,
                'is_student_certified' => strtoupper($result->{$responseNode}->is_student_certified) == 'T' ? 1 : 0,
                'user_type' => $result->{$responseNode}->user_type,
                'user_status' => $result->{$responseNode}->user_status,
                'is_certified' => $result->{$responseNode}->is_certified,
                'gender' => strtoupper($result->{$responseNode}->gender) == 'F' ? 2 : (strtoupper($result->{$responseNode}->gender) == 'M' ? 1 : 0),
                'original' => $result->{$responseNode}
            ];

            return new User($attributes);
        }

        return [];
    }
}