<?php

class Eshop_WebEnquiry_Block_Adminhtml_Webenquiry_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("webenquiryGrid");
				$this->setDefaultSort("sno");
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
		    		$collection = Mage::getModel("webenquiry/webenquiry")->getCollection();
			    }
			    else
			    {
			    	$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $role_name);
				    $data=$site->getData();
		            $website_id=$data[0]['website_id'];
				    $collection = Mage::getModel("webenquiry/webenquiry")->getCollection()->addFilter('website_id',$website_id);
				}
			    
				
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("sno", array(
				"header" => Mage::helper("webenquiry")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "sno",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("webenquiry")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("webenquiry")->__("Email"),
				"index" => "email",
				));
					$this->addColumn('post_date', array(
						'header'    => Mage::helper('webenquiry')->__('Date'),
						'index'     => 'post_date',
						'type'      => 'datetime',
					));
				$this->addColumn("subject", array(
				"header" => Mage::helper("webenquiry")->__("Subject"),
				"index" => "subject",
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
				
				$this->addColumn('website_id', array(
				'header' => Mage::helper('webenquiry')->__('Website'),
				'index' => 'website_id',
				'type' => 'options',
				'options'=>$website_array,				
				));
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('sno');
			$this->getMassactionBlock()->setFormFieldName('snos');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_webenquiry', array(
					 'label'=> Mage::helper('webenquiry')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_webenquiry/massRemove'),
					 'confirm' => Mage::helper('webenquiry')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array[0]='test';
			$data_array[1]='test 2';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(Eshop_WebEnquiry_Block_Adminhtml_Webenquiry_Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}