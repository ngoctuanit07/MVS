<?php
class Eshop_WebEnquiry_Block_Adminhtml_Webenquiry_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("webenquiry_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("webenquiry")->__("Enquiry Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("webenquiry")->__("Enquiry Information"),
				"title" => Mage::helper("webenquiry")->__("Enquiry Information"),
				"content" => $this->getLayout()->createBlock("webenquiry/adminhtml_webenquiry_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
