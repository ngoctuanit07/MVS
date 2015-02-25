<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table enquirymanagement(sno int not null auto_increment, name varchar(100), email varchar(100), product_id varchar(50),  website_id varchar(100),  subject varchar(150), post_date date, message varchar(1000), primary key(sno));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 