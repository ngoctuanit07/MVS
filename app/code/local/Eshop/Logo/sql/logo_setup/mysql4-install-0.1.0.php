<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table logo(id int not null auto_increment, 
image varchar(100), 
website int(11), 
primary key(id));
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 