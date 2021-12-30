<?php
class St_Setting_Model_Mysql4_Setting extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("setting/setting", "setting_id");
    }
}