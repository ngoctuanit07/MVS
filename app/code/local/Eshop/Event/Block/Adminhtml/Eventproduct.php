<?php


class Eshop_Event_Block_Adminhtml_Eventproduct extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_eventproduct";
	$this->_blockGroup = "event";
	$this->_headerText = Mage::helper("event")->__("Event Product Manager");
	$this->_addButtonLabel = Mage::helper("event")->__("Add New Event Product");
	parent::__construct();
	
	}

}