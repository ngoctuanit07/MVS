<?php
class Eshop_Merchant_Block_Adminhtml_Merchnat_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("merchnat_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("merchant")->__("Merchant Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("merchant")->__("Merchant Information"),
				"title" => Mage::helper("merchant")->__("Merchant Information"),
				"content" => $this->getLayout()->createBlock("merchant/adminhtml_merchnat_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
