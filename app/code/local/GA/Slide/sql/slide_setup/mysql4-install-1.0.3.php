<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('slide')};
CREATE TABLE {$this->getTable('slide')} (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
	`content` text NULL,
  `status` smallint(6) NOT NULL default '0',
	`weblink` varchar(255) NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 