<?php

/**
 * Licentia Pictura - Banner Management
 *
 * NOTICE OF LICENSE
 * This source file is subject to the European Union Public Licence
 * It is available through the world-wide-web at this URL:
 * http://joinup.ec.europa.eu/software/page/eupl/licence-eupl
 *
 * @title      Background Management
 * @category   Marketing
 * @package    Licentia
 * @author     Bento Vilas Boas <bento@licentia.pt>
 * @copyright  Copyright (c) 2014 Licentia - http://licentia.pt
 * @license    European Union Public Licence
 */
$installer = $this;
$installer->startSetup();

$installer->run("

-- ----------------------------
--  Table structure for `pictura_banners`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_banners')}`;
CREATE TABLE `{$this->getTable('pictura_banners')}` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `is_active` enum('0','1') DEFAULT '0',
  `impressions` smallint(6) NOT NULL DEFAULT '0',
  `clicks` smallint(6) NOT NULL DEFAULT '0',
  `conversions_number` smallint(6) NOT NULL DEFAULT '0',
  `conversions_amount` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`banner_id`),
  UNIQUE KEY `uni_code` (`code`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Banners List';

-- ----------------------------
--  Table structure for `pictura_content`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_content')}`;
CREATE TABLE `{$this->getTable('pictura_content')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  `banner_id` int(11) DEFAULT NULL,
  `content` text,
  `use_default` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `FK_PICTURA_CONTENT_STOREID` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_CONTENT_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Banners Content Store View';

-- ----------------------------
--  Table structure for `pictura_logs`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_logs')}`;
CREATE TABLE `{$this->getTable('pictura_logs')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `type` enum('impression','click','conversion') DEFAULT 'impression',
  `order_id` int(10) unsigned DEFAULT NULL,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  KEY `store_id` (`store_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `FK_PICTURA_LOGS_ORDERID` FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales_flat_order')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_LOGS_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_LOGS_STOREID` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Logs';
-- ----------------------------
--  Table structure for `pictura_positions`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_positions')}`;
CREATE TABLE `{$this->getTable('pictura_positions')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `position_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  CONSTRAINT `FK_PICTURA_POSITIONS_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Banners Positions';

-- ----------------------------
--  Table structure for `pictura_rules_cart`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_rules_cart')}`;
CREATE TABLE `{$this->getTable('pictura_rules_cart')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `promo_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  KEY `promo_id` (`promo_id`),
  CONSTRAINT `FK_PICTURA_CART_RULEID` FOREIGN KEY (`promo_id`) REFERENCES `{$this->getTable('salesrule')}` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_CART_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Cart Promo Rules';

-- ----------------------------
--  Table structure for `pictura_rules_catalog`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_rules_catalog')}`;
CREATE TABLE `{$this->getTable('pictura_rules_catalog')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `promo_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  KEY `promo_id` (`promo_id`),
  CONSTRAINT `FK_PICTURA_CATALOG_RULEID` FOREIGN KEY (`promo_id`) REFERENCES `{$this->getTable('catalogrule')}` (`rule_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_CATALOG_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Catalog Promo Rules';

-- ----------------------------
--  Table structure for `pictura_segments`
-- ----------------------------
DROP TABLE IF EXISTS `{$this->getTable('pictura_segments')}`;
CREATE TABLE `{$this->getTable('pictura_segments')}` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `segment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `banner_id` (`banner_id`),
  KEY `segment_id` (`segment_id`),
  CONSTRAINT `FK_PICTURA_SEGMENTS_SEGID` FOREIGN KEY (`segment_id`) REFERENCES `{$this->getTable('magna_segments')}` (`segment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PICTURA_SEGMENTS_BID` FOREIGN KEY (`banner_id`) REFERENCES `{$this->getTable('pictura_banners')}` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictura - Segments Access';
");

$installer->endSetup();
