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
class Licentia_Pictura_Block_Adminhtml_Banners_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('importerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('pictura/banners')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('banner_id', array(
            'header' => $this->__('ID'),
            'width' => '50px',
            'index' => 'banner_id',
        ));

        $this->addColumn('name', array(
            'header' => $this->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('date_start', array(
            'header' => $this->__('Date Start'),
            'type' => 'date',
            'index' => 'date_start',
        ));

        $this->addColumn('date_end', array(
            'header' => $this->__('Date End'),
            'type' => 'date',
            'index' => 'date_end',
        ));

        $this->addColumn('impressions', array(
            'header' => $this->__('Impressions'),
            'type' => 'number',
            'width' => '100px',
            'index' => 'impressions',
        ));

        $this->addColumn('clicks', array(
            'header' => $this->__('Clicks'),
            'type' => 'number',
            'width' => '100px',
            'index' => 'clicks',
        ));

        $this->addColumn('conversions_number', array(
            'header' => $this->__('Conv. Number'),
            'type' => 'number',
            'index' => 'conversions_number',
        ));

        $this->addColumn('conversions_amount', array(
            'header' => $this->__('Conv. Amount'),
            'type' => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'conversions_amount',
        ));

        $this->addColumn('code', array(
            'header' => $this->__('Tracking Code'),
            'index' => 'code',
            'align' => 'right',
        ));

        $this->addColumn('is_active', array(
            'header' => $this->__('Active'),
            'type' => 'options',
            'width' => '100px',
            'align' => 'center',
            'options' => array('0' => $this->__('No'), '1' => $this->__('Yes')),
            'index' => 'is_active',
        ));

        $this->addColumn('evo', array(
            'header' => $this->__('View'),
            'type' => 'action',
            'align' => 'center',
            'width' => '80px',
            'filter' => false,
            'sortable' => false,
            'actions' => array(array(
                    'url' => $this->getUrl('*/pictura_logs', array('id' => '$banner_id')),
                    'caption' => $this->__('Logs'),
                )),
            'index' => 'type',
            'sortable' => false
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
