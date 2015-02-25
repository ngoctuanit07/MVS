<?php
class Eshop_Event_Block_Adminhtml_Event_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("event_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("event")->__("Event Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("event")->__("Event Information"),
				"title" => Mage::helper("event")->__("Event Information"),
				"content" => $this->getLayout()->createBlock("event/adminhtml_event_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
