<?php

class St_Calorycarbslevel_Block_Adminhtml_Calorycarbslevel_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "levelid";
				$this->_blockGroup = "calorycarbslevel";
				$this->_controller = "adminhtml_calorycarbslevel";
				$this->_updateButton("save", "label", Mage::helper("calorycarbslevel")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("calorycarbslevel")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("calorycarbslevel")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("calorycarbslevel_data") && Mage::registry("calorycarbslevel_data")->getId() ){

				    return Mage::helper("calorycarbslevel")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("calorycarbslevel_data")->getId()));

				}
				else{

				     return Mage::helper("calorycarbslevel")->__("Add Item");

				}
		}
}