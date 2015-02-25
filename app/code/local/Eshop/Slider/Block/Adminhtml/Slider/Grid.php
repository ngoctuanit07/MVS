<?php

class Eshop_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("sliderGrid");
				$this->setDefaultSort("slide_id");
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
		    		$collection = Mage::getModel("slider/slider")->getCollection();
			    }
			    else
			    {
			    	$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $role_name);
				    $data=$site->getData();
		            $website_id=$data[0]['website_id'];
				    $collection = Mage::getModel("slider/slider")->getCollection()->addFilter('website',$website_id);
				}
			    
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("slide_id", array(
				"header" => Mage::helper("slider")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "slide_id",
				));
                
				$this->addColumn("title", array(
				"header" => Mage::helper("slider")->__("Title"),
				"index" => "title",
				));
				$this->addColumn("content", array(
				"header" => Mage::helper("slider")->__("Content"),
				"index" => "content",
				));
				
				$this->addColumn('status', array(
				'header' => Mage::helper('slider')->__('Status'),
				'index' => 'status',
				'type' => 'options',
				'options'=>Eshop_Slider_Block_Adminhtml_Slider_Grid::getOptionArray3(),				
				));
				
				/*		
				$this->addColumn("weblink", array(
				"header" => Mage::helper("slider")->__("Weblink"),
				"index" => "weblink",
				));
				*/
				
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
				"header" => Mage::helper("slider")->__("Website"),
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
			$this->setMassactionIdField('slide_id');
			$this->getMassactionBlock()->setFormFieldName('slide_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_slider', array(
					 'label'=> Mage::helper('slider')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_slider/massRemove'),
					 'confirm' => Mage::helper('slider')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray3()
		{
            $data_array=array(); 
			$data_array[0]='Enable';
			$data_array[1]='Disable';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(Eshop_Slider_Block_Adminhtml_Slider_Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}