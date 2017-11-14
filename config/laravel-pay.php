<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午2:12
 */

return [

    // 支付宝参数配置
    'alipay' => [
        // 支付宝appID
        'appid' => env('PAY_ALIPAY_APPID', ''),

        // 支付宝私有密匙
        'private_key' => env('PAY_ALIPAY_PRIVATE_KEY', ''),

        // 支付宝公有密匙
        'public_key' => env('PAY_ALIPAY_PUBLIC_KEY', ''),

        // 接口版本
        'api_version' => env('PAY_ALIPAY_API_VERSION', '1.0'),

        // 签名类型
        'sign_type' => env('PAY_ALIPAY_SIGN_TYPE', 'RSA2'),

        // 提交的字符编码格式
        'charset' => env('PAY_ALIPAY_CHARSET','utf-8'),

        // 返回结果格式化类型
        'format' => env('PAY_ALIPAY_FORMAT', 'json'),

        // 用户授权登录
        'auth_scope' => env('PAY_ALIPAY_AUTH_SCOPE', 'auth_user'),
    ],

];