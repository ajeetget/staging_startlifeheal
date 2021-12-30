<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("order", "ordertime", array("type"=>"varchar"));
$installer->endSetup();
	 