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
class Licentia_Pictura_Block_Adminhtml_Logs_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('logsrGrid');
        $this->setDefaultSort('record_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('pictura/logs')->getCollection();

        $id = $this->getRequest()->getParam('id');
        $collection->addFieldToFilter('banner_id', $id);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('record_id', array(
            'header' => $this->__('ID'),
            'width' => '50px',
            'index' => 'record_id',
        ));

        $this->addColumn('store_id', array(
            'header' => $this->__('Store'),
            'align' => 'left',
            'type' => 'store',
            'index' => 'store_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $this->__('Created At'),
            'align' => 'left',
            'type' => 'datetime',
            'index' => 'created_at',
        ));


        $this->addColumn('type', array(
            'header' => $this->__('Type'),
            'type' => 'options',
            'options' => array('impression' => $this->__('Impression'), 'click' => $this->__('Click'), 'conversion' => $this->__('Conversion')),
            'index' => 'type',
        ));

        $this->addColumn('order_id', array(
            'header' => $this->__('Order'),
            'default' => 'N/A',
            'index' => 'order_id',
            'frame_callback' => array($this, 'orderResult'),
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row) {
        return false;
    }

    public function orderResult($value) {

        if ((int) $value == 0) {
            return 'N/A';
        }

        $url = $this->getUrl('*/sales_order/', array('order_id' => $value));
        return'<a href="' . $url . '">' . $this->__('Order') . '</a>';
    }

}
