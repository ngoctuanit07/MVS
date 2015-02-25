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
class Aitoc_Aitpermissions_Block_Rewrite_AdminCatalogProductEditTabWebsites
    extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Websites
{
    public function getWebsiteCollection()
    {
    	$collection = Mage::getModel('core/website')->getResourceCollection();

        $role = Mage::getSingleton('aitpermissions/role');

    	if ($role->isPermissionsEnabled())
        {
            $collection->addIdFilter($role->getAllowedWebsiteIds());
        }
        
        return $collection->load();
    }
}