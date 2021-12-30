<?php
	
class St_Weeklyclientinfo_Block_Adminhtml_Weeklyclientinfo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "clientid";
				$this->_blockGroup = "weeklyclientinfo";
				$this->_controller = "adminhtml_weeklyclientinfo";
				$this->_updateButton("save", "label", Mage::helper("weeklyclientinfo")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("weeklyclientinfo")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("weeklyclientinfo")->__("Save And Continue Edit"),
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
				if( Mage::registry("weeklyclientinfo_data") && Mage::registry("weeklyclientinfo_data")->getId() ){

				    return Mage::helper("weeklyclientinfo")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("weeklyclientinfo_data")->getId()));

				} 
				else{

				     return Mage::helper("weeklyclientinfo")->__("Add Item");

				}
		}
}