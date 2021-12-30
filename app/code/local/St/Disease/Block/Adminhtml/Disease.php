<?php


class St_Disease_Block_Adminhtml_Disease extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_disease";
	$this->_blockGroup = "disease";
	$this->_headerText = Mage::helper("disease")->__("Disease Manager");
	$this->_addButtonLabel = Mage::helper("disease")->__("Add New Item");
	parent::__construct();
	
	}

}