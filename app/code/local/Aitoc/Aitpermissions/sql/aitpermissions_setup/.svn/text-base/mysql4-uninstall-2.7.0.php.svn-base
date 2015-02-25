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
$installer = $this;

$installer->startSetup();

$catalogSetup = Mage::getResourceModel('catalog/setup', 'catalog_setup');

$catalogSetup->updateAttribute('catalog_product', 'created_by', 'is_visible', '0'); 
$catalogSetup->updateAttribute('catalog_product', 'created_by', 'source_model', ''); 
$catalogSetup->updateAttribute('catalog_product', 'created_by', 'frontend_label', ''); 
$catalogSetup->updateAttribute('catalog_product', 'created_by', 'frontend_input', ''); 

$installer->endSetup();