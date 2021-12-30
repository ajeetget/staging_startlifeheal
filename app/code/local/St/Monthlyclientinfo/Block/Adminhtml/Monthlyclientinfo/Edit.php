<?php
	
class St_Monthlyclientinfo_Block_Adminhtml_Monthlyclientinfo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "monthlyinfoid";
				$this->_blockGroup = "monthlyclientinfo";
				$this->_controller = "adminhtml_monthlyclientinfo";
				$this->_updateButton("save", "label", Mage::helper("monthlyclientinfo")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("monthlyclientinfo")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("monthlyclientinfo")->__("Save And Continue Edit"),
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
				if( Mage::registry("monthlyclientinfo_data") && Mage::registry("monthlyclientinfo_data")->getId() ){

				    return Mage::helper("monthlyclientinfo")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("monthlyclientinfo_data")->getId()));

				} 
				else{

				     return Mage::helper("monthlyclientinfo")->__("Add Item");

				}
		}
}