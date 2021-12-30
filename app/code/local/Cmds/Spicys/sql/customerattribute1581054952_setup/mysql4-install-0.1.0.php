<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("customer", "spicy",  array(
    "type"     => "int",
    "backend"  => "",
    "label"    => "Spicy Label",
    "input"    => "select",
    "source"   => "spicys/eav_entity_attribute_source_customeroptions15810549520",
    "visible"  => true,
    "required" => false,
    "default" => "1",
    "frontend" => "",
    "unique"     => false,
    "note"       => "default Normal"

	));

        $attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "spicy");

        
$used_in_forms=array();

$used_in_forms[]="adminhtml_customer";
$used_in_forms[]="checkout_register";
$used_in_forms[]="customer_account_create";
$used_in_forms[]="customer_account_edit";
$used_in_forms[]="adminhtml_checkout";
        $attribute->setData("used_in_forms", $used_in_forms)
		->setData("is_used_for_customer_segment", true)
		->setData("is_system", 0)
		->setData("is_user_defined", 1)
		->setData("is_visible", 1)
		->setData("sort_order", 100)
		;
        $attribute->save();


	
$installer->endSetup();
	 