<?php


class St_Weeklyclientinfo_Block_Adminhtml_Weeklyclientinfo extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_weeklyclientinfo";
	$this->_blockGroup = "weeklyclientinfo";
	$this->_headerText = Mage::helper("weeklyclientinfo")->__("Weekly Client Report Manager");
	$this->_addButtonLabel = Mage::helper("weeklyclientinfo")->__("Add New Item");
	parent::__construct();
	
	}

}