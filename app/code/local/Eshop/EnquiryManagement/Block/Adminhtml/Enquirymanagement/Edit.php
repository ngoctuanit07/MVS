<?php
	
class Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "sno";
				$this->_blockGroup = "enquirymanagement";
				$this->_controller = "adminhtml_enquirymanagement";
				$this->_updateButton("save", "label", Mage::helper("enquirymanagement")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("enquirymanagement")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("enquirymanagement")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("enquirymanagement_data") && Mage::registry("enquirymanagement_data")->getId() ){

				    return Mage::helper("enquirymanagement")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("enquirymanagement_data")->getId()));

				} 
				else{

				     return Mage::helper("enquirymanagement")->__("Add Item");

				}
		}
}