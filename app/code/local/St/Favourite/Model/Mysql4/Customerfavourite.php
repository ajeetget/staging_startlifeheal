<?php
class St_Favourite_Model_Mysql4_Customerfavourite extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("favourite/customerfavourite", "custfav_id");
    }
}