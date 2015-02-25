<?php


class Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_enquirymanagement";
	$this->_blockGroup = "enquirymanagement";
	$this->_headerText = Mage::helper("enquirymanagement")->__("Enquirymanagement Manager");
	$this->_addButtonLabel = Mage::helper("enquirymanagement")->__("Add New Item");
	parent::__construct();
	
	}

}