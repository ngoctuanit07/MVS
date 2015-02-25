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
class Licentia_Pictura_Block_Adminhtml_Banners_Edit_Tab_Catalog extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Initialize grid
     * Set sort settings
     */
    public function __construct() {
        parent::__construct();
        $this->setId('banner_catalog_grid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Add websites to catalog rules collection
     * Set collection
     *
     * @return Mage_Adminhtml_Block_Promo_Catalog_Grid
     */
    protected function _prepareCollection() {
        /** @var $collection Mage_CatalogRule_Model_Mysql4_Rule_Collection */
        $collection = Mage::getModel('catalogrule/rule')
                ->getResourceCollection();
        $collection->addWebsitesToResult();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns() {

        $current = Mage::registry('current_banner');

        $this->addColumn('rule_id', array(
            'header' => Mage::helper('salesrule')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'rule_id',
            'values' => Mage::getModel('pictura/cart')->getSelectedCatalogIds($current->getId()),
        ));

        $this->addColumn('rule_name', array(
            'header' => Mage::helper('catalogrule')->__('Rule Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('from_date', array(
            'header' => Mage::helper('catalogrule')->__('Date Start'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'date',
            'index' => 'from_date',
        ));

        $this->addColumn('to_date', array(
            'header' => Mage::helper('catalogrule')->__('Date Expire'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'date',
            'default' => '--',
            'index' => 'to_date',
        ));

        $this->addColumn('cat_is_active', array(
            'header' => Mage::helper('catalogrule')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                1 => Mage::helper('catalogrule')->__('Active'),
                0 => Mage::helper('catalogrule')->__('Inactive')
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('rule_website', array(
                'header' => Mage::helper('catalogrule')->__('Website'),
                'align' => 'left',
                'index' => 'website_ids',
                'type' => 'options',
                'sortable' => false,
                'options' => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(),
                'width' => 200,
            ));
        }

        parent::_prepareColumns();
        return $this;
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/gridcatalog', array('_current' => true));
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('rule_id');
        $this->getMassactionBlock()->setFormFieldName('catalog[]');

        $this->getMassactionBlock()->addItem('dummy', array(
            'label' => $this->__('Ignore'),
            'url' => $this->getUrl('*/*/*'),
        ));

        return $this;
    }

    protected function _toHtml() {

        $current = Mage::registry('current_banner');
        $js = "
        Event.observe(window, 'load', function() {
            " . $this->getId() . "_massactionJsObject.setCheckedValues('" . implode(',', $current->getData('catalog')) . "');
            " . $this->getId() . "_massactionJsObject.onGridInit();
        });";

        $html = '<script type="text/javascript">
        //<![CDATA[
           ' . $js . '
        //]]>
        </script>';

        return $html . parent::_toHtml();
    }

}
