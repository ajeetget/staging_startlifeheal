<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table disease(
         disease_id int not null auto_increment, 
        disease  varchar(200) default null, 
         lowrange  varchar(200) default null, 
         highrange  varchar(200) default null, 
         comment  varchar(200) default null, 
         label  varchar(200) default null, 
        primary key(disease_id)
   );
    
SQLTEXT;

$installer->run($sql);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 