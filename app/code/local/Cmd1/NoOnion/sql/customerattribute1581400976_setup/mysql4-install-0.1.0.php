<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("customer", "nogarlicnoonion",  array(
    "type"     => "int",
    "backend"  => "",
    "label"    => "No Onion/Garlic",
    "input"    => "select",
    "source"   => "eav/entity_attribute_source_boolean",
    "visible"  => true,
    "required" => false,
    "default" => "0",
    "frontend" => "",
    "unique"     => false,
    "note"       => ""

	));

        $attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "nogarlicnoonion");

        
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
		->setData("is_visible", 0)
		->setData("sort_order", 100)
		;
        $attribute->save();


	
$installer->endSetup();
	 