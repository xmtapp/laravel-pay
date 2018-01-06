<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/17
 * Time: 下午4:51
 */

namespace XmtApp\Payment\Alipay;


use XmtApp\Payment\Contracts\Notify;
use Symfony\Component\HttpFoundation\Response;

class HandleNotify implements Notify
{
    /**
     * 异步支付回调
     * @param callable $callback
     * @return mixed
     */
    public function handleNotify(callable $callback)
    {
        $notify = $this->getNotify();
        $flag = $this->check($notify->all());
        if($flag) {//验证成功
            $successful = 'TRADE_SUCCESS' === $notify->get('trade_status');

            $handleResult = call_user_func_array($callback, [$notify, $successful]);
            if (is_bool($handleResult) && $handleResult) {
                $response = 'success';
            } else {
                $response = 'fail';
            }
        } else {
            //验证失败
            $response = 'fail';
        }

        return new Response($response);
    }

    /**
     * 同步支付回调
     * @param callable $callback
     * @return mixed
     */
    public function handleReturn(callable $callback)
    {
        $notify = $this->getNotify();
        $flag = $this->check($notify->all());
        if($flag) {//验证成功
            $handleResult = call_user_func_array($callback, [$notify, true]);
            if (is_bool($handleResult) && $handleResult) {
                $response = 'success';
            } else {
                $response = 'fail';
            }
        } else {
            //验证失败
            $response = 'fail';
        }

        return new Response($response);
    }


    /**
     * 验签方法
     * @param $arr 验签支付宝返回的信息，使用支付宝公钥。
     * @return boolean
     */
    private function check($arr){
        $aop = resolve(Alipay::class);

        $result = $aop->rsaCheckV1($arr, $aop->alipayPublicKey, $aop->signType);
        return $result;
    }

    /**
     * @return static
     */
    public function getNotify() {
        return resolve('Illuminate\Http\Request');
    }
}