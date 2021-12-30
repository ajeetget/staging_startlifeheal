<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table calorycarbslevel(
   levelid int not null auto_increment, 
   level1_carbs varchar(150),level1_calory varchar(150),
   level2_carbs varchar(150),level2_calory varchar(150),
   level3_carbs varchar(150),level3_calory varchar(150),
   level4_carbs varchar(150),level4_calory varchar(150),
   level5_carbs varchar(150),level5_calory varchar(150),
   level6_carbs varchar(150),level6_calory varchar(150),
   primary key(levelid)

);
  
		
SQLTEXT;

$installer->run($sql);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 