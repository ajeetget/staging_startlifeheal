<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table bmi(bmi_id int not null auto_increment,

height_ft varchar(200) default NULL, 
height_in varchar(200)  default NULL, 
weight varchar(200)  default NULL, 
gender varchar(200)  default NULL, 
email varchar(200) default NULL, 
living_with_diabetes varchar(200)  default NULL, 
bmi_result varchar(200) default NULL,
bmi_status varchar(200) default NULL,
created_at date default null,
primary key(bmi_id)

 );
    
		
SQLTEXT;

$installer->run($sql);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 