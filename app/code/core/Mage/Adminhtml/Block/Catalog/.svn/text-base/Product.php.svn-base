<?php 
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog manage products block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Catalog_Product extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product.phtml');
    }

    /**
     * Prepare button and grid
     *
     * @return Mage_Adminhtml_Block_Catalog_Product
     */
    protected function _prepareLayout()
    {
    			$admin_user_session = Mage::getSingleton('admin/session');
			   	$adminuserId = $admin_user_session->getUser()->getUserId();
			   	$adminuseremail = $admin_user_session->getUser()->getEmail();
			    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
			    $role_name = $role_data['role_name'];
			    $role_id = $role_data['role_id'];
			    //echo $adminuseremail;
			    
			    if($role_id === '1')
			    {
		    		$collection = Mage::getModel("catalog/product")->getCollection();
		    		$admin_user= TRUE;
		    		
			    }
			    else
			    {
			    	//echo $role_id;
			    	
			    	$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $role_name);
				    $data=$site->getData();
		            $website_id=$data[0]['website_id'];
		            $collection = Mage::getResourceModel('catalog/product_collection');
					$collection->addWebsiteFilter($website_id);
				    //$collection = Mage::getModel("catalog/product")->getCollection()->addFilter('website',$website_id);
				 	$sku_count =count($collection);
				    $resource = Mage::getSingleton('core/resource');
					$readConnection = $resource->getConnection('core_read');
					$merchant_max_sku ="select b.max_sku from merchant as a join merchant_plan_info as b on b.merchant_id = a.id where a.email= '$adminuseremail';";
					//echo $merchant_max_sku;
					$results = $readConnection->fetchAll($merchant_max_sku);
					$max_sku_allowed = $results[0]['max_sku'];
					//echo $max_sku_allowed;
					//echo $sku_count;
					
					
				}	
    	if ($sku_count < $max_sku_allowed || $admin_user)
    	{
        $this->_addButton('add_new', array(
            'label'   => Mage::helper('catalog')->__('Add Product'),
            'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
            'class'   => 'add'
        ));
    	}
        $this->setChild('grid', $this->getLayout()->createBlock('adminhtml/catalog_product_grid', 'product.grid'));
        return parent::_prepareLayout();
    
    }

    /**
     * Deprecated since 1.3.2
     *
     * @return string
     */
    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
               return false;
        }
        return true;
    }
}
?>