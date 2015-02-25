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
class Licentia_Pictura_Block_Widget_Block extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

    static protected $_widgetUsageMap = array();

    protected function _toHtml() {
        $banners = $this->getData('banner_id');
        if ($banners) {
            $block = Mage::getModel('pictura/banners')->getBannersForImpression($this);
            $helper = Mage::helper('cms');
            $processor = $helper->getBlockTemplateProcessor();
            return $processor->filter($block);
        }
        return '';
    }

}
