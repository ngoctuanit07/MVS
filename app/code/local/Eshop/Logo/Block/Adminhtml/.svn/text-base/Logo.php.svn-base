<?php


class Eshop_Logo_Block_Adminhtml_Logo extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
				$flag=0;
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
				    $data_count=count($collection->getData());
				    if($data_count>0)
				    {
				    	$flag=1;
				    }
				}
	
		$this->_controller = "adminhtml_logo";
		$this->_blockGroup = "logo";
		$this->_headerText = Mage::helper("logo")->__("Logo Manager");
		$this->_addButtonLabel = Mage::helper("logo")->__("Add New Logo");
		parent::__construct();
		if($flag==1)
		{
			$this->_removeButton('add');
		}		
	}
}