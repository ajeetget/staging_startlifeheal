<?php
class Food_Heal_Block_Adminhtml_Order_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("order_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("heal")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("heal")->__("Item Information"),
				"title" => Mage::helper("heal")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("heal/adminhtml_order_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
