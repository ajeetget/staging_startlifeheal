<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table  weeklyclientinfo (
  clientid int(11) not null auto_increment,
  date timestamp not null default current_timestamp,
  name varchar(255) not null,
  mobile varchar(255) not null,
  height varchar(255) not null,
  weight varchar(255) not null,
  waist varchar(255) not null,
  bpsystolic varchar(255) not null,
  bpdiastloc varchar(255) not null,
  customerid varchar(255) not null,
  email varchar(255) not null,
  message text not null,
  primary key (clientid)
);
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 