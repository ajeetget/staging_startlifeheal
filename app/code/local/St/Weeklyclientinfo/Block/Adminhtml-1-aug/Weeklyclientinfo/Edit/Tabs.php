<?php
class St_Weeklyclientinfo_Block_Adminhtml_Weeklyclientinfo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("weeklyclientinfo_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("weeklyclientinfo")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("weeklyclientinfo")->__("Item Information"),
				"title" => Mage::helper("weeklyclientinfo")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("weeklyclientinfo/adminhtml_weeklyclientinfo_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
