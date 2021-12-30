<?php
class St_Disease_Block_Adminhtml_Disease_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("disease_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("disease")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("disease")->__("Item Information"),
				"title" => Mage::helper("disease")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("disease/adminhtml_disease_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
