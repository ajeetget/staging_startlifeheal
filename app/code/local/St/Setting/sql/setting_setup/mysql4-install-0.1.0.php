<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table setting(setting_id int not null auto_increment, name varchar(255) default null, value varchar(255) default null, primary key(setting_id));
    
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 