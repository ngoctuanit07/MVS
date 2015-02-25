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
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Product_Listall extends Mage_Catalog_Block_Product_List
{
   
   /**
	 * set custom collection
	 * @par limit_page,sort_order,sort_direction,p
	*/
   function setCustomCollection($collection){
   		$par 				= Mage::getSingleton('catalog/session')->setParamsMemorizeAllowed(true)->getData();
   		$gridPerPage 		= Mage::getStoreConfig('catalog/frontend/grid_per_page');
		$parSortLimit 		= (isset($par['limit_page'])) ? (int)$par['limit_page'] : $gridPerPage;
		$parSortOrder 		= (isset($par['sort_order'])) ? $par['sort_order'] : 'created_at';
		$parSortDirection 	= (isset($par['sort_direction'])) ? $par['sort_direction'] : 'asc';
		$parCurrentPage 	= (isset($_REQUEST['p'])) ? intval($_REQUEST['p']) : 1;
		
		$collection->setCurPage($parCurrentPage);
		
   		if ($parSortLimit) {
            $collection->setPageSize($parSortLimit);
        }
        if ($parSortOrder) {
            $collection->setOrder($parSortOrder, $parSortDirection);
        }
        return $collection;
   }

   /**
    * Retrieve loaded category collection
    *
    * @return Mage_Eav_Model_Entity_Collection_Abstract
   **/
   protected function _getProductCollection()
   {
      $cat_id=Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
      $cat_name=Mage::getModel('catalog/layer')->getCurrentCategory()->getName();
      
      $category = Mage::getModel('catalog/category')->load($cat_id);
      
      $collection_merchant = Mage::getModel("merchant/merchnat")->getCollection()
      							->addFilter('business_category',$cat_name)
      							->addFieldToSelect('store_alias');
      							
       
      $web_name_array=$collection_merchant->getData();
      
      $merged_ids=array();
      
      if(count($web_name_array)>=1)
      {
		  foreach($web_name_array as $website)
	      {
	     		$web_name=$website['store_alias'];
	     		$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $web_name)->addFieldToSelect('website_id');
	            $site_data=$site->getData();
	     		$website_id=$site_data[0]['website_id'];
	     		$website = Mage::app()->getWebsite($website_id);
	     		$store_id=$website->getDefaultGroup()->getDefaultStore()->getId(); 
	
	     		$collection1 = Mage::getResourceModel('catalog/product_collection')
	      				->setStoreId($store_id)
	      				->addCategoryFilter($category);
	      				
	      		$merged_ids = array_merge($merged_ids, $collection1->getAllIds());		
	      }
	      
	      $collection = Mage::getResourceModel('catalog/product_collection')
                        ->addFieldToFilter('entity_id', $merged_ids)
                        ->addAttributeToSelect('*');
      }
      else
      {
      		$collection = new Varien_Data_Collection();
      }
      
      
      
      //echo "<pre>";
      //print_r($collection->getData());die;				
      $this->setCustomCollection($collection);
      $this->setProductCollection($collection);
      return $collection;
   }
}
