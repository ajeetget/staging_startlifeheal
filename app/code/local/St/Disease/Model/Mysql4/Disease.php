<?php
class St_Disease_Model_Mysql4_Disease extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("disease/disease", "disease_id");
    }
}