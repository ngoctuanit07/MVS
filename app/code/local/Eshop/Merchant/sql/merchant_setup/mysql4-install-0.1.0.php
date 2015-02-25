<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table merchant(id int not null auto_increment,
name varchar(100),
email varchar(100),
store_name varchar(100),
store_alias varchar(100),
business_category varchar(100),
merchant_plan varchar(100),
owner_company_name varchar(100),
registration_no varchar(100),
address varchar(300),
city varchar(100),
state varchar(100),
postcode varchar(100),
country varchar(100),
telephone varchar(100),
fax varchar(100),
order_status varchar(100),
status varchar(20),
primary key(id));		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 