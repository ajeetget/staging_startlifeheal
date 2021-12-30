<?php


class Food_Heal_Block_Adminhtml_Order extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_order";
	$this->_blockGroup = "heal";
	$this->_headerText = Mage::helper("heal")->__("Order Manager");
	$this->_addButtonLabel = Mage::helper("heal")->__("Add New Item");
	parent::__construct();
	
	}

}