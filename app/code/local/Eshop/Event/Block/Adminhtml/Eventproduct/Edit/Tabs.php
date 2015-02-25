<?php
class Eshop_Event_Block_Adminhtml_Eventproduct_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("eventproduct_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("event")->__("Event Product Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("event")->__("Event Product Information"),
				"title" => Mage::helper("event")->__("Event Product Information"),
				"content" => $this->getLayout()->createBlock("event/adminhtml_eventproduct_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
