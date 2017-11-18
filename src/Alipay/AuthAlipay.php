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
            $res_attrs = $result->{$responseNode};

            $user = new User();
            //userID
            $user->setAttribute('id', $res_attrs->user_id);
            // 昵称
            if (isset($res_attrs->nick_name)) {
                $user->setAttribute('nickname', $res_attrs->nick_name);
            } else {
                $user->setAttribute('nickname', $res_attrs->user_id);
            }
            // 头像
            if (isset($res_attrs->avatar)) {
                $user->setAttribute('avatar', $res_attrs->avatar);
            }
            // 性别
            if (isset($res_attrs->gender)) {
                $gender = strtoupper($result->{$responseNode}->gender) == 'F' ? 2 : (strtoupper($result->{$responseNode}->gender) == 'M' ? 1 : 0);
            } else {
                $gender = 0;
            }
            $user->setAttribute('gender', $gender);
            // 省份
            if (isset($res_attrs->province)) {
                $user->setAttribute('provinc', $res_attrs->provinc);
            }
            // 城市
            if (isset($res_attrs->city)) {
                $user->setAttribute('city', $res_attrs->city);
            }
            // 是否通过学生认证
            if (isset($res_attrs->is_student_certified)) {
                $user->setAttribute('is_student_certified', $res_attrs->is_student_certified);
            }
            // 用户类型
            if (isset($res_attrs->user_type)) {
                $user->setAttribute('user_type', $res_attrs->user_type);
            }
            // 用户状态
            if (isset($res_attrs->user_status)) {
                $user->setAttribute('user_status', $res_attrs->user_status);
            }
            // 是否通过认证
            if (isset($res_attrs->is_certified)) {
                $user->setAttribute('is_certified', $res_attrs->is_certified);
            }

            $user->setAttribute('original', $res_attrs);

            return $user;
        }

        return [];
    }
}