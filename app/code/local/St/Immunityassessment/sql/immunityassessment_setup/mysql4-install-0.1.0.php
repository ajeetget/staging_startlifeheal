<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table immunutyassessment(id int not null auto_increment,
 name varchar(100)  default NULL,
mobileno varchar(100) default NULL,
cold varchar(100) default NULL,
headache varchar(100) default NULL,
migranes varchar(100) default NULL,
fever varchar(100) default NULL,
jointache varchar(100) default NULL,
bodyache varchar(100) default NULL,
stomach_infection varchar(100) default NULL,
uti varchar(100) default NULL,
primary key(id)

);

SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 