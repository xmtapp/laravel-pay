<?php
/**
 * Created by PhpStorm.
 * User: DongYao
 * Date: 2017/11/16
 * Time: 下午1:42
 */

namespace XmtApp\Payment\Alipay;

use ArrayAccess;
use JsonSerializable;

use XmtApp\Payment\Contracts\UserInfo;
use XmtApp\Payment\Traits\HasAttributes;

class User implements ArrayAccess, UserInfo, JsonSerializable
{
    use HasAttributes;

    /**
     * User constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the username for the user.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getAttribute('username', $this->getId());
    }

    /**
     * Get the nickname / username for the user.
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->getAttribute('nickname');
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Get the e-mail address of the user.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getAttribute('email');
    }

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->getAttribute('avatar');
    }

    /**
     * Get gender for the user
     * return integer 1 man  2 women 0 unknow
     */
    public function getGender()
    {
        return $this->getAttribute('gender');
    }

    /**
     * Get province for the user
     * @return string
     */
    public function getProvince()
    {
        return $this->getAttribute('province');
    }

    /**
     * Get city for the user
     * @return string
     */
    public function getCity()
    {
        return $this->getAttribute('city');
    }

    /**
     * 获取是否是学生
     *
     * @return integer 0 否 1 是
     */
    public function getIsStudentCertified()
    {
        return $this->getAttribute('is_student_certified');
    }

    /**
     * 获取用户的类型
     *
     * @return integer 1 代表公司账户 2 代表个人账户
     */
    public function getUserType()
    {
        return $this->getAttribute('user_type');
    }

    /**
     * 获取用户的状态
     * Q代表快速注册用户
     * T代表已认证用户
     * B代表被冻结账户
     * W代表已注册，未激活的账户
     * @return string
     */
    public function getUserStatus() {
        return $this->getAttribute('user_status');
    }

    /**
     * Get the original attributes.
     *
     * @return array
     */
    public function getOriginal()
    {
        return $this->getAttribute('original');
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->attributes;
    }

}