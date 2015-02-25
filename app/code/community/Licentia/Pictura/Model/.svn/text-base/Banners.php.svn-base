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
class Licentia_Pictura_Model_Banners extends Mage_Core_Model_Abstract {

    const MYSQL_DATE = 'yyyy-MM-dd';

    protected function _construct() {
        $this->_init('pictura/banners');
    }

    public function getBannerTypes($includeNone = false) {

        $return = array();

        if ($includeNone) {
            $return[] = array('value' => '0', 'label' => Mage::helper('pictura')->__("-- $includeNone --"));
        }

        $return[] = array('value' => 'header', 'label' => Mage::helper('pictura')->__('Header'));
        $return[] = array('value' => 'footer', 'label' => Mage::helper('pictura')->__('Footer'));
        $return[] = array('value' => 'content', 'label' => Mage::helper('pictura')->__('Content'));
        $return[] = array('value' => 'left', 'label' => Mage::helper('pictura')->__('Left'));
        $return[] = array('value' => 'right', 'label' => Mage::helper('pictura')->__('Right'));

        return $return;
    }

    public function save() {

        if ($this->getData('validate')) {

            if (!$this->getCode()) {
                $this->setData('code', $this->getNewCode($this->getId()));
            } else {
                $codeExists = $this->getCollection()
                        ->addFieldToFilter('code', $this->getCode());
                if ($this->getId()) {
                    $codeExists->addFieldToFilter('banner_id', array('neq' => $this->getId()));
                }

                if ($codeExists->count() > 0) {
                    throw new Mage_Core_Exception(Mage::helper('pictura')->__('Tracking Code must be unique'));
                }
            }

            $segments = (array) $this->getData('segments');
            if (in_array('0', $segments)) {
                $segments = array();
            }

            $positions = (array) $this->getData('positions');
            if (in_array('0', $positions)) {
                $positions = array();
            }

            $cart = $this->getData('cart');
            $catalog = $this->getData('catalog');
            $content = $this->getData('content');
            $default = $this->getData('use_default');

            $ko = true;
            foreach ($content as $test) {
                if (strlen($test) > 0) {
                    $ko = false;
                    break;
                }
            }

            if ($ko) {
                throw new Mage_Core_Exception('Please Fill At least One Content Area');
            }

            $this->unsetData('positions');
            $this->unsetData('segments');
            $this->unsetData('cart');
            $this->unsetData('catalog');
            $this->unsetData('content');
            $this->unsetData('use_default');

            $data = $this->getData();

            foreach ($data as $value) {
                if (is_array($this->getData($value))) {
                    $this->unsetData($value);
                }
            }
        }

        $model = parent::save();

        if ($this->getData('validate')) {
            Mage::getModel('pictura/positions')->updateBanner($model->getId(), $positions);
            Mage::getModel('pictura/segments')->updateBanner($model->getId(), $segments);
            Mage::getModel('pictura/cart')->updateBanner($model->getId(), $cart);
            Mage::getModel('pictura/catalog')->updateBanner($model->getId(), $catalog);
            Mage::getModel('pictura/content')->updateBanner($model->getId(), $content, $default);
        }
        return $model;
    }

    protected function _afterLoad() {
        parent::_afterLoad();

        $this->setData('segments', Mage::getModel('pictura/segments')->getSelectedSegmentsIds($this->getId()));
        $this->setData('cart', Mage::getModel('pictura/cart')->getSelectedCartIds($this->getId()));
        $this->setData('catalog', Mage::getModel('pictura/catalog')->getSelectedCatalogIds($this->getId()));
        $this->setData('content', Mage::getModel('pictura/content')->getSelectedContent($this->getId()));
        $this->setData('positions', Mage::getModel('pictura/positions')->getSelectedPositionsIds($this->getId()));
    }

    public function getBannersForImpression($data) {

        $type = $data->getData('btype');
        $bannerId = explode(',', $data->getData('banner_id'));
        $storeId = Mage::app()->getStore()->getId();
        $positions = $data->getData('positions');

        if ($type == 'selected' && count($bannerId) == 0) {
            return '';
        }

        $collection = $this->getCollection();

        if ($type == 'selected') {
            $collection->addStoreFilter($storeId)
                    ->addActiveFilter()
                    ->addPositionsFilter($positions)
                    ->addsegmentsFilter()
                    ->addSelectedBanners($bannerId)
            ;
        }
        if ($type == 'cart') {
            $collection->addStoreFilter($storeId)
                    ->addActiveFilter()
                    ->addPositionsFilter($positions)
                    ->addsegmentsFilter()
                    ->addCartBanners()
            ;
        }
        if ($type == 'catalog') {
            $collection->addStoreFilter($storeId)
                    ->addActiveFilter()
                    ->addPositionsFilter($positions)
                    ->addsegmentsFilter()
                    ->addCatalogBanners()
            ;
        }

        if ($collection->count() == 1) {
            $banner = $collection->getFirstItem();
            $content = $banner->getData('content');

            try {
                $nBanner = $this->load($banner->getId());
                $nBanner->setData('impressions', $nBanner->getData('impressions') + 1)->save();

                $data = array();
                $data['created_at'] = now();
                $data['store_id'] = Mage::app()->getStore()->getId();
                $data['banner_id'] = $banner->getId();
                $data['type'] = 'impression';
                Mage::getModel('pictura/logs')->setData($data)->save();
            } catch (Exception $e) {
                Mage::logException($e);
            }
            return $content;
        }
    }

    public function getNewCode($id = false) {
        $collection = $this->getCollection()->setOrder('banner_id', 'DESC')->setPageSize(1);

        if (!$id) {
            if ($collection->count() == 1) {
                $id = $collection->getFirstItem()->getId() + 1;
            } else {
                $id = 1;
            }
        }
        return $id . substr(md5($id), 0, 7 - strlen($id));
    }

}
