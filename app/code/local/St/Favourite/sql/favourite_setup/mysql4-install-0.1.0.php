<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table customerfavourite
( 
  custfav_id int not null auto_increment,
  custid   varchar(100),
  mobileno  varchar(100),
  custname varchar(255),
  combo_id varchar(255),
  combo_name varchar(255),       
  combo_option_id varchar(255),
  combo_selection_id varchar(255),
  product_is_combo_child varchar(255),
  productid   varchar(255),
  productname varchar(255),
  creation_time     DATETIME DEFAULT CURRENT_TIMESTAMP,
  
  primary key(custfav_id)
);
        
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 