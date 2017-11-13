<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/13
 * Time: 下午12:01
 */

namespace XmtApp\Payment\Contracts;

interface Notify
{
    /**
     * 异步支付回调
     * @param callable $callback
     * @return mixed
     */
    public function handleNotify(callable $callback);

    /**
     * 同步支付回调
     * @param callable $callback
     * @return mixed
     */
    public function handleReturn(callable  $callback);
}