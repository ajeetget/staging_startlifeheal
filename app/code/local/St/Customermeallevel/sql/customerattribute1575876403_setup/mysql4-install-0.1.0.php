<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("customer", "meallevel",  array(
    "type"     => "int",
    "backend"  => "",
    "label"    => "Meal Level",
    "input"    => "select",
    "source"   => "customermeallevel/eav_entity_attribute_source_customeroptions15758764030",
    "visible"  => true,
    "required" => false,
    "default" => "",
    "frontend" => "",
    "unique"     => false,
    "note"       => ""

	));

        $attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "meallevel");

        
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
		->setData("sort_order", 95)
		;
        $attribute->save();


	
$installer->endSetup();
	 