<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE monthlyclientinfo (
  monthlyinfoid int(11) not null AUTO_INCREMENT,
  clientid timestamp not null,
  date timestamp not null DEFAULT CURRENT_TIMESTAMP,
  name   varchar(255) not null,
  mobile varchar(255) not null,
  hba1c text,
  hscrp text, 
  hdl  text,
  ldl  text,
  vitamind  text,
  b12  text,
  fasting  text,
  pp  text,
  homair  text,
  homocysteine  text,
  comments text,
  PRIMARY KEY (monthlyinfoid)
);
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 