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
class Licentia_Pictura_Model_Mysql4_Banners_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('pictura/banners');
    }

    public function toOptionHash($valueField = 'banner_id', $labelField = 'name') {
        $res = array();
        foreach ($this as $item) {
            $res[$item->getData($valueField)] = $item->getData($labelField);
        }

        return $res;
    }

    public function getAllIds($field = false) {
        if (!$field) {
            return parent::getAllIds();
        }

        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->columns($field, 'main_table');
        return $this->getConnection()->fetchCol($idsSelect);
    }

    public function addStoreFilter($storeId) {
        $table = $this->getTable('pictura/content');
        $this->getSelect()->join($table, 'main_table.banner_id=' . $table . '.banner_id AND ' . $table . '. store_id=' . $storeId);

        return $this;
    }

    public function addActiveFilter() {
        $date = Mage::app()->getLocale()->date()->get(Licentia_Pictura_Model_Banners::MYSQL_DATE);

        $this->addFieldToFilter(
                        array('date_start', 'date_start'), array(
                    array('lteq' => $date),
                    array('null' => true)
                ))
                ->addFieldToFilter(
                        array('date_end', 'date_end'), array(
                    array('gteq' => $date),
                    array('null' => true)
                ))
                ->addFieldToFilter('is_active', 1);
        return $this;
    }

    public function addsegmentsFilter() {

        if (!Mage::helper('pictura')->magna()) {
            return $this;
        }

        $segmentsIds = Mage::helper('magna')->getCustomerSegmentsIds();
        $table = $this->getTable('pictura/segments');
        $this->getSelect()->joinLeft($table, 'main_table.banner_id=' . $table . '.banner_id', array());

        $this->getSelect()->where($table . '.segment_id IS NULL OR ' . $table . '.segment_id IN (?)', $segmentsIds);

        return $this;
    }

    public function addPositionsFilter($positions) {

        if (!is_array($positions) && strlen($positions) == 0) {
            return $this;
        }

        if (is_array($positions) && strlen($positions[0]) == 0) {
            return $this;
        }

        if (!is_array($positions)) {
            $positions = explode(',', $positions);
        }

        if (count($positions) == 0) {
            return $this;
        }

        $table = $this->getTable('pictura/positions');
        $this->getSelect()->joinLeft($table, 'main_table.banner_id=' . $table . '.banner_id', array());

        $this->getSelect()->where($table . '.position_id IS NULL OR ' . $table . '.position_id IN (?)', $positions);

        return $this;
    }

    public function addCartBanners() {

        $rule = Mage::getModel('salesrule/rule')->getCollection();
        $siteId = Mage::app()->getWebsite()->getId();
        $groupId = 0;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        $rule->addWebsiteGroupDateFilter($siteId, $groupId);
        $ruleIds = $rule->getAllIds();


        $table = $this->getTable('pictura/cart');
        $this->getSelect()->joinLeft($table, 'main_table.banner_id=' . $table . '.banner_id', array());
        $this->getSelect()->where($table . '.promo_id IN (?)', $ruleIds);

        $this->setPageSize(1);
        $this->getSelect()->orderRand();
        $this->getSelect()->group('main_table.banner_id');

        return $this;
    }

    public function addCatalogBanners() {

        $siteId = Mage::app()->getWebsite()->getId();
        $groupId = 0;

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }

        $rule = Mage::getModel('catalogrule/rule')->getCollection();
        $rule->addWebsiteFilter($siteId)
                ->addIsActiveFilter();

        $rule->getSelect()
                ->joinInner(
                        array('customer_group_ids' => $this->getTable('catalogrule/customer_group')), $this->getConnection()->quoteInto(
                                'main_table.rule_id'
                                . ' = customer_group_ids.rule_id'
                                . ' AND customer_group_ids.customer_group_id = ?', (int) $groupId
                        ), array()
        );

        $ruleIds = $rule->getAllIds();

        $table = $this->getTable('pictura/catalog');
        $this->getSelect()->joinLeft($table, 'main_table.banner_id=' . $table . '.banner_id', array());
        $this->getSelect()->where($table . '.promo_id IN (?)', $ruleIds);

        $this->setPageSize(1);
        $this->getSelect()->orderRand();
        $this->getSelect()->group('main_table.banner_id');

        return $this;
    }

    public function addSelectedBanners($bannersIds) {

        $this->addFieldToFilter('main_table.banner_id', array('in' => $bannersIds))
                ->setPageSize(1);

        $this->getSelect()->orderRand();
        $this->getSelect()->group('main_table.banner_id');

        return $this;
    }

}
