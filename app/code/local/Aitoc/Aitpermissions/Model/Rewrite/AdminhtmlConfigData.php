<?php
/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.9.3
 * @license:     NsnkcMilFb7W0iFXa17c232AskjWauIUC7wI4CNyQ3
 * @copyright:   Copyright (c) 2014 AITOC, Inc. (http://www.aitoc.com)
 */
class Aitoc_Aitpermissions_Model_Rewrite_AdminhtmlConfigData extends Mage_Adminhtml_Model_Config_Data
{

    public function load()
    {
        if ($this->getSection() != Mage::app()->getRequest()->getParam('section')) {
            $this->setSection(Mage::app()->getRequest()->getParam('section'));
            $this->_configData = null;
        }
        return parent::load();
    }
}