<?php
class St_Weeklyclientinfo_Model_Mysql4_Weeklyclientinfo extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("weeklyclientinfo/weeklyclientinfo", "clientid");
    }
}