<?php
class St_Monthlyclientinfo_Model_Mysql4_Monthlyclientinfo extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("monthlyclientinfo/monthlyclientinfo", "monthlyinfoid");
    }
}