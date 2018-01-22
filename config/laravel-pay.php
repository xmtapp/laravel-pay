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

        // App私有密匙
        'app_private_key' => env('PAY_ALIPAY_APP_PRIVATE_KEY', ''),

        // 支付宝公有密匙
        'alipay_public_key' => env('PAY_ALIPAY_PUBLIC_KEY', ''),

        // 接口版本
        'api_version' => env('PAY_ALIPAY_API_VERSION', '1.0'),

        // 签名类型
        'sign_type' => env('PAY_ALIPAY_SIGN_TYPE', 'RSA2'),

        // 是否需要对参数加密
        'need_encrypt' => env('PAY_ALIPAY_NEED_ENCRYPT', false),

        // 签名类型
        'aes_key' => env('PAY_ALIPAY_AES_KEY', ''),

        // 提交的字符编码格式
        'charset' => env('PAY_ALIPAY_CHARSET','utf-8'),

        // 返回结果格式化类型
        'format' => env('PAY_ALIPAY_FORMAT', 'json'),

        // 用户授权登录
        'auth_scope' => env('PAY_ALIPAY_AUTH_SCOPE', 'auth_user'),

        'seller_id' => env('PAY_ALIPAY_SELLER_ID', ''),

        // 是否启用沙箱配置测试
        'sandbox_enabled' => env('PAY_ALIPAY_SANDBOX_ENABLED', false),

        // 支付宝沙箱参数配置
        'sandbox' => [
            // 支付宝appID
            'appid' => env('PAY_SANDBOX_ALIPAY_APPID', ''),

            // APP私有密匙
            'app_private_key' => env('PAY_SANDBOX_ALIPAY_APP_PRIVATE_KEY', ''),

            // 支付宝公有密匙
            'alipay_public_key' => env('PAY_SANDBOX_ALIPAY_PUBLIC_KEY', ''),

            'seller_id' => env('PAY_SANDBOX_ALIPAY_SELLER_ID', ''),
        ],
    ],

];