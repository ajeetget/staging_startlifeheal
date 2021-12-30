<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table foodcategory(
cat_id int not null auto_increment,
 name varchar(100) not null ,
 status int not null default 1,
 primary key(cat_id )
);

create table fooditem(
item_id int not null auto_increment primary key,
cat_id int not null ,
name varchar(255) not null,
pdf varchar(255) default null,
video text,
status int not null default 1
);
  
		
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 