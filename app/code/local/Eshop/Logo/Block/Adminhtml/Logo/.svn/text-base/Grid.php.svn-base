<?php

class Eshop_Logo_Block_Adminhtml_Logo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("logoGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$admin_user_session = Mage::getSingleton('admin/session');
			   	$adminuserId = $admin_user_session->getUser()->getUserId();
			    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
			    $role_name = $role_data['role_name'];
			    $role_id = $role_data['role_id'];
			    
			    if($role_id=='1')
			    {
		    		$collection = Mage::getModel("logo/logo")->getCollection();
			    }
			    else
			    {
			    	$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $role_name);
				    $data=$site->getData();
		            $website_id=$data[0]['website_id'];
				    $collection = Mage::getModel("logo/logo")->getCollection()->addFilter('website',$website_id);
				}	
				
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("logo")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				
				$admin_user_session = Mage::getSingleton('admin/session');
			   	$adminuserId = $admin_user_session->getUser()->getUserId();
			    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
			    $role_name = $role_data['role_name'];
			    $role_id = $role_data['role_id'];
			    //echo "<pre>";print_r($role_data);die;
      
				
				$site = Mage::getResourceModel('core/website_collection');
			    $website_array=array();

			     if($role_id==1)
			     {
				    	foreach($site->getData() as $website){ 
				         $website_array[$website['website_id']]=$website['name'];   
					     } 		
			     }
			     else
			     {
			     		foreach($site->getData() as $website){
			     		  if($website['name']==$role_name) 
			     		  {
			     		 		$website_array[$website['website_id']]=$website['name']; 
			     		  }
					    }
			     }
						
				$this->addColumn("website", array(
				"header" => Mage::helper("logo")->__("Website"),
				"index" => "website",
				'type' => 'options',
				'options'=> $website_array,
				));
				
				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_logo', array(
					 'label'=> Mage::helper('logo')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_logo/massRemove'),
					 'confirm' => Mage::helper('logo')->__('Are you sure?')
				));
			return $this;
		}
			
}