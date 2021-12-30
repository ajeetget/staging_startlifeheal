<?php
class St_Foodpdf_Model_Mysql4_Fooditem extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("foodpdf/fooditem", "item_id");
    }
}