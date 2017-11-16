<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/16
 * Time: 下午1:40
 */

namespace XmtApp\Payment\Contracts;


interface UserInfo
{
    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the nickname / username for the user.
     *
     * @return string
     */
    public function getNickname();

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the e-mail address of the user.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar();

    /**
     * Get the gender for the user.
     * @return integer
     */
    public function getGender();
}