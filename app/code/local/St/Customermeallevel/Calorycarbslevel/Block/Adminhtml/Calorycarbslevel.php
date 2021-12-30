<?php


class St_Calorycarbslevel_Block_Adminhtml_Calorycarbslevel extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_calorycarbslevel";
	$this->_blockGroup = "calorycarbslevel";
	$this->_headerText = Mage::helper("calorycarbslevel")->__("Calorycarbslevel Manager");
	$this->_addButtonLabel = Mage::helper("calorycarbslevel")->__("Add New Item");
	parent::__construct();
	
	}

}