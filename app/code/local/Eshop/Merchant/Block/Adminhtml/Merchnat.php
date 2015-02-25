<?php


class Eshop_Merchant_Block_Adminhtml_Merchnat extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_merchnat";
	$this->_blockGroup = "merchant";
	$this->_headerText = Mage::helper("merchant")->__("Merchant Manager");
	$this->_addButtonLabel = Mage::helper("merchant")->__("Add New Merchant");
	parent::__construct();
	
	}

}