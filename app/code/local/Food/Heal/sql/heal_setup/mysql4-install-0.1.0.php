<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE healorder (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `orderdate` varchar(255) NOT NULL default '',
  `mobile` varchar(255) NOT NULL default '',
  `alernatemobile` varchar(255) NOT NULL default '',
  `foodtype` varchar(255) NOT NULL default '',
  `fooditems` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
)
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 