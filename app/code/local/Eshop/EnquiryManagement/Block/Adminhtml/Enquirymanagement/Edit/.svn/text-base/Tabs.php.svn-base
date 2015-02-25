<?php
class Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("enquirymanagement_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("enquirymanagement")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("enquirymanagement")->__("Item Information"),
				"title" => Mage::helper("enquirymanagement")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("enquirymanagement/adminhtml_enquirymanagement_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
