<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 7/29/15
 * Time: 4:42 PM
 */

namespace Dandelionapi\apis;


class DandelionBase
{
    public $token;
    /**
     * @deprecated
     */
    public $appId;
    /**
     * @deprecated
     */
    public $appKey;

    protected static $_dollarPrefix = [
        'app_key' => '$app_key',
        'app_id'  => '$app_id',
    ];

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function hasToken()
    {
        return isset($this->token);
    }

    /**
     * @param mixed $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return bool
     */
    public function hasAppId()
    {
        return isset($this->appId);
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->appKey;
    }

    /**
     * @return bool
     */
    public function hasAppKey()
    {
        return isset($this->appKey);
    }

    /**
     * @param mixed $appKey
     */
    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
        return $this;
    }



}