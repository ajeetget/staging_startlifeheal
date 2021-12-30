<?php

class St_Disease_Block_Adminhtml_Disease_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "disease_id";
				$this->_blockGroup = "disease";
				$this->_controller = "adminhtml_disease";
				$this->_updateButton("save", "label", Mage::helper("disease")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("disease")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("disease")->__("Save And Continue Edit"),
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
				if( Mage::registry("disease_data") && Mage::registry("disease_data")->getId() ){

				    return Mage::helper("disease")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("disease_data")->getId()));

				}
				else{

				     return Mage::helper("disease")->__("Add Item");

				}
		}
}