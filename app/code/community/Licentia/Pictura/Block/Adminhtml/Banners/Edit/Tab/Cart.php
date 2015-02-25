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
class Licentia_Pictura_Block_Adminhtml_Banners_Edit_Tab_Cart extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Initialize grid
     * Set sort settings
     */
    public function __construct() {
        parent::__construct();
        $this->setId('banner_cart_grid');
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Add websites to sales rules collection
     * Set collection
     *
     * @return Mage_Adminhtml_Block_Promo_Quote_Grid
     */
    protected function _prepareCollection() {
        /** @var $collection Mage_SalesRule_Model_Mysql4_Rule_Collection */
        $collection = Mage::getModel('salesrule/rule')
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
            'values' => $current->getData('cart'),
        ));

        $this->addColumn('rule_name', array(
            'header' => Mage::helper('salesrule')->__('Rule Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('coupon_code', array(
            'header' => Mage::helper('salesrule')->__('Coupon Code'),
            'align' => 'left',
            'width' => '150px',
            'index' => 'code',
        ));

        $this->addColumn('from_date', array(
            'header' => Mage::helper('salesrule')->__('Date Start'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'date',
            'index' => 'from_date',
        ));

        $this->addColumn('to_date', array(
            'header' => Mage::helper('salesrule')->__('Date Expire'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'date',
            'default' => '--',
            'index' => 'to_date',
        ));

        $this->addColumn('cart_is_active', array(
            'header' => Mage::helper('salesrule')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('rule_website', array(
                'header' => Mage::helper('salesrule')->__('Website'),
                'align' => 'left',
                'index' => 'website_ids',
                'type' => 'options',
                'sortable' => false,
                'options' => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(),
                'width' => 200,
            ));
        }

        $this->addColumn('sort_order', array(
            'header' => Mage::helper('salesrule')->__('Priority'),
            'align' => 'right',
            'index' => 'sort_order',
            'width' => 100,
        ));

        parent::_prepareColumns();
        return $this;
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/gridcart', array('_current' => true));
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('rule_id');
        $this->getMassactionBlock()->setFormFieldName('cart[]');

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
            " . $this->getId() . "_massactionJsObject.setCheckedValues('" . implode(',', $current->getData('cart')) . "');
            " . $this->getId() . "_massactionJsObject.onGridInit();
        });";

        $html = '<script type="text/javascript">
        //<![CDATA[
           ' . $js . '
        //]]>
        </script>';

        return $html . "<style type='text/css'>table.massaction div.right {display:none;}</style>" . parent::_toHtml();
    }

}
