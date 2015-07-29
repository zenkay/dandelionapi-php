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
    protected $_appId;
    protected $_appKey;

    /**
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->_appKey;
    }

    /**
     * @return bool
     */
    public function hasAppKey()
    {
        return isset($this->_appKey);
    }

    /**
     * @param mixed $appKey
     */
    public function setAppKey($appKey)
    {
        $this->_appKey = $appKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->_appId;
    }

    /**
     * @return bool
     */
    public function hasAppId()
    {
        return isset($this->_appId);
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->_appId = $appId;
        return $this;
    }


}