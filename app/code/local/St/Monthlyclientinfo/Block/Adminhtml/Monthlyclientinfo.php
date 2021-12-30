<?php


class St_Monthlyclientinfo_Block_Adminhtml_Monthlyclientinfo extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_monthlyclientinfo";
	$this->_blockGroup = "monthlyclientinfo";
	$this->_headerText = Mage::helper("monthlyclientinfo")->__("Monthly Client Report Manager");
	$this->_addButtonLabel = Mage::helper("monthlyclientinfo")->__("Add New Item");
	parent::__construct();
	
	}

}