<?php
class Food_Heal_Model_Mysql4_Order extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("heal/order", "id");
    }
}