<?php
/* DO NOT MODIFY THIS FILE! THIS IS TEMPORARY FILE AND WILL BE RE-GENERATED AS SOON AS CACHE CLEARED. */

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_CustomerCredit
 * @copyright  Copyright (c) 2012 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * Customer Credit extension
 *
 * @category   MageWorx
 * @package    MageWorx_CustomerCredit
 * @author     MageWorx Dev Team
 */
class Aitoc_Aitpermissions_Block_Rewrite_AdminCustomerGrid extends Mage_Adminhtml_Block_Customer_Grid
{   
    public function setCollection($collection) {
        
        if (Mage::helper('customercredit')->isEnabled() && Mage::helper('customercredit')->isEnabledCustomerBalanceGridColumn()) {        
            $fields = array();
            foreach (Mage::getConfig()->getFieldset('customer_account') as $code=>$node) {
                if ($node->is('name')) {
                    //$this->addAttributeToSelect($code);
                    $fields[$code] = $code;
                }
            }

            $joinCond = 'credit_tbl.customer_id = e.entity_id';
            if (!Mage::helper('customercredit')->isScopePerWebsite()) {
                $joinCond .= ' AND credit_tbl.website_id = 0';
            } else if(!Mage::app()->isSingleStoreMode()){
                $joinCond .= ' AND credit_tbl.website_id = e.website_id';
//                $joinCond .= ' AND credit_tbl.website_id != 0';
            }
            $collection->getSelect()->joinLeft(array('credit_tbl'=>$collection->getTable('customercredit/credit')),"(".$joinCond.")",'');        
//            if (!Mage::helper('customercredit')->isScopePerWebsite()) {
//                $collection->addExpressionAttributeToSelect('credit_value', 'IFNULL(credit_tbl.`value`, 0)', $fields);
//            } else {
                $collection->addExpressionAttributeToSelect('credit_value', 'IFNULL(credit_tbl.`value`, 0)', $fields); 
//            }
            
//echo $collection->getSelect()->__toString();
//$sql = $collection->getSelect()->assemble();
            //$collection->getSelect()->reset()->from(array('e' => new Zend_Db_Expr('('.$sql.')')), '*');
        }
        return parent::setCollection($collection);
    }
    

    protected function _prepareColumns() {        
        if (Mage::helper('customercredit')->isEnabled() && Mage::helper('customercredit')->isEnabledCustomerBalanceGridColumn()) {
            $this->addColumnAfter('credit_value', array(            
                //'renderer'  => 'mageworx/tweaks_adminhtml_sales_order_grid_renderer_products',
                'header' => Mage::helper('customercredit')->__('Credit Balance'),
                'index' => 'credit_value',
                'width' => '100px',
                'renderer'  => 'customercredit/adminhtml_widget_grid_column_renderer_currency'
                ), 'group');
        }    
        return parent::_prepareColumns();
    }
    
    public function getCurrentCurrencyCode()
    {
        if (is_null($this->_currentCurrencyCode)) {
            $this->_currentCurrencyCode = (count($this->_storeIds) > 0)
                ? Mage::app()->getStore(array_shift($this->_storeIds))->getBaseCurrencyCode()
                : Mage::app()->getStore()->getBaseCurrencyCode();
        }
        return $this->_currentCurrencyCode;
    }
}


/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.9.3
 * @license:     NsnkcMilFb7W0iFXa17c232AskjWauIUC7wI4CNyQ3
 * @copyright:   Copyright (c) 2014 AITOC, Inc. (http://www.aitoc.com)
 */
class MageWorx_CustomerCredit_Block_Adminhtml_Customer_Grid extends Aitoc_Aitpermissions_Block_Rewrite_AdminCustomerGrid
{
	protected function _prepareColumns()
	{
		parent::_prepareColumns();

        $role = Mage::getSingleton('aitpermissions/role');

		if ($role->isPermissionsEnabled())
		{
            if (!Mage::helper('aitpermissions')->isShowingAllCustomers() &&
                isset($this->_columns['website_id']))
            {
                unset($this->_columns['website_id']);
                $allowedWebsiteIds = $role->getAllowedWebsiteIds();

                if (count($allowedWebsiteIds) > 1)
                {
                    $websiteFilter = array();
                    foreach ($allowedWebsiteIds as $allowedWebsiteId)
                    {
                        $website = Mage::getModel('core/website')->load($allowedWebsiteId);
                        $websiteFilter[$allowedWebsiteId] = $website->getData('name');
                    }

                    $this->addColumn('website_id', array(
                        'header' => Mage::helper('customer')->__('Website'),
                        'align' => 'center',
                        'width' => '80px',
                        'type' => 'options',
                        'options' => $websiteFilter,
                        'index' => 'website_id',
                    ));
                }
            }
		}
        
        return $this;
	}
}

