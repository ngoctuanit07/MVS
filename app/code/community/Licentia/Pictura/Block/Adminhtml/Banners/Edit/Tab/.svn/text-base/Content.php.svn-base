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
class Licentia_Pictura_Block_Adminhtml_Banners_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $current = Mage::registry("current_banner");
        $content = $current->getData('content');

        $stores = Mage::getSingleton('adminhtml/system_store')->getStoresStructure(false);

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('tab_id' => $this->getTabId()));
        $wysiwygConfig->setData('hidden', 1);
        $wysiwygConfig->setData('add_images', false);

        $fieldset = $form->addFieldset("Content_form_default", array("legend" => $this->__('Default')));

        $js = '<style type="text/css">#togglemessage, .add-image{ display:none !important;} #content_default{width:425px !important;height:125px !important; }</style>';
        $fieldset->addField('content_default', 'editor', array(
            "label" => $this->__("Content - Default"),
            "name" => "content[0]",
            'config' => $wysiwygConfig,
            'wysiwyg' => true,
        ))->setAfterElementHtml($js);

        $form->addValues(array('content_default' => $content[0]['content']));

        if (!isset($stores[2]) && count($stores[1]['children'][1]['children']) == 1) {
            $final = $stores[1]['children'][1]['children'][1];
            $fieldset->addField('use_default' . $final['value'], 'hidden', array(
                "name" => "use_default[" . $final['value'] . "]",
                "value" => 1,
            ));
            $stores = array();
        }

        foreach ($stores as $key => $store) {
            $fieldset[$store['value']] = $form->addFieldset("Content_form_" . $key, array("legend" => $this->__($store['label'])));

            foreach ($store['children'] as $children) {
                foreach ($children['children'] as $final) {

                    $checked = $content[$final['value']]['use_default'] == 1 ? 'checked="checked"' : '';

                    $js = "<script> Event.observe(window, 'load', function() { $('use_default[" . $final['value'] . "]').observe('click', function(e){
                                if(this.checked){
                                    $('content_" . $final['value'] . "').setAttribute('disabled',1);
                                }else{
                                    $('content_" . $final['value'] . "').removeAttribute('disabled');
                                }
                            })})</script>"
                            . '<input  ' . $checked . ' value="1" name="use_default[' . $final['value'] . ']"  id="use_default[' . $final['value'] . ']" type="checkbox"> <label for="use_default[' . $final['value'] . ']">' . $this->__('Use Default') . '</label>'
                            . '<style type="text/css">#togglemessage, .add-image{ display:none !important;} #content_' . $final['value'] . '{width:425px !important;height:125px !important; }</style>';

                    $fieldset[$store['value']]->addField('content_' . $final['value'], 'editor', array(
                        "label" => $this->__($store['label'] . ' / ' . $children['label'] . ' / ' . $final['label']),
                        "name" => "content[" . $final['value'] . "]",
                        'config' => $wysiwygConfig,
                        'disabled' => $content[$final['value']]['use_default'] == 1 ? 1 : 0,
                        'wysiwyg' => true,
                    ))->setAfterElementHtml($js);

                    $form->addValues(array('content_' . $final['value'] => $content[$final['value']]['content']));
                }
            }
        }

        return parent::_prepareForm();
    }

}
