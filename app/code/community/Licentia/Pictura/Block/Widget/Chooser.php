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

class Licentia_Pictura_Block_Widget_Chooser extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct($arguments = array()) {
        parent::__construct($arguments);
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('chooser_is_active' => '1'));
    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $uniqId = 'pictura_' . $element->getId();

        $sourceUrl = $this->getUrl('*/pictura_widget/chooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
                ->setElement($element)
                ->setTranslationHelper($this->getTranslationHelper())
                ->setConfig($this->getConfig())
                ->setFieldsetId($this->getFieldsetId())
                ->setSourceUrl($sourceUrl)
                ->setUniqId($uniqId);

        if ($element->getValue()) {
            $chooser->setLabel('Selected');
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    public function _toHtml() {

        $values = $this->getRequest()->getParam('element_value');

        $chooserJsObject = $this->getId();
        $js = '<script type="text/javascript">
//<![CDATA[
    mass = ' . $this->getData('id') . 'JsObject;
    ' . $this->getData('id') . '_massactionJsObject = mass.massaction;

    mass.massaction.setCheckedValues("' . $values . '");
    mass.massaction.onGridInit();

    $$("table.massaction button").each(function(item){
        item.removeAttribute("onclick");
        Event.observe(item, "click",function(){
            if(varienStringArray.count(mass.massaction.checkedString)==0){
                alert("Please Select Banners");
                return false;
            }else{

                ' . $chooserJsObject . '.setElementValue(mass.massaction.getCheckedValues());
                ' . $chooserJsObject . '.setElementLabel("Selected");
                ' . $chooserJsObject . '.close();
            }
        });
    });

      //]]>
</script>

<style>.massaction .entry-edit .field-row label, .massaction .entry-edit fieldset .select{display:none !important;}</style>

        ';

        return parent::_toHtml() . $js;
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('pictura/banners')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('chooser_id', array(
            'header' => $this->__('ID'),
            'align' => 'right',
            'index' => 'banner_id',
            'width' => 50
        ));

        $this->addColumn('chooser_title', array(
            'header' => $this->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('chooser_code', array(
            'header' => $this->__('Code'),
            'align' => 'left',
            'index' => 'code',
        ));

        $this->addColumn('chooser_is_active', array(
            'header' => $this->__('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                0 => $this->__('Disabled'),
                1 => $this->__('Enabled')
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($item) {
        return false;
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banners');

        $this->getMassactionBlock()->addItem('banners', array(
            'label' => $this->__('Add Banners'),
            'url' => $this->getUrl('*/*/*'),
        ));

        return $this;
    }

    public function getGridUrl() {
        return $this->getUrl('*/pictura_widget/chooser', array('_current' => true));
    }

}
