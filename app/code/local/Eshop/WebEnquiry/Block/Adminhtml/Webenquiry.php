<?php


class Eshop_WebEnquiry_Block_Adminhtml_Webenquiry extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
	$this->_controller = "adminhtml_webenquiry";
	$this->_blockGroup = "webenquiry";
	$this->_headerText = Mage::helper("webenquiry")->__("Web Enquiry Manager");
	$this->_addButtonLabel = Mage::helper("webenquiry")->__("Add New Enquiry");
	parent::__construct();
	$this->_removeButton('add');
	}

}