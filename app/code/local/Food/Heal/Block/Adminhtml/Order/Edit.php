<?php
	
class Food_Heal_Block_Adminhtml_Order_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "heal";
				$this->_controller = "adminhtml_order";
				$this->_updateButton("save", "label", Mage::helper("heal")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("heal")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("heal")->__("Save And Continue Edit"),
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
				if( Mage::registry("order_data") && Mage::registry("order_data")->getId() ){

				    return Mage::helper("heal")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("order_data")->getId()));

				} 
				else{

				     return Mage::helper("heal")->__("Add Item");

				}
		}
}