<?php
class St_Bmi_Model_Mysql4_Bmi extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("bmi/bmi", "bmi_id");
    }
}