<?php
	
class Eshop_WebEnquiry_Block_Adminhtml_Webenquiry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "sno";
				$this->_blockGroup = "webenquiry";
				$this->_controller = "adminhtml_webenquiry";
				$this->_updateButton("save", "label", Mage::helper("webenquiry")->__("Send Email"));
				$this->_updateButton("delete", "label", Mage::helper("webenquiry")->__("Delete Enquiry"));

				/*
				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("webenquiry")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100); 
				*/


				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("webenquiry_data") && Mage::registry("webenquiry_data")->getId() ){

				    return Mage::helper("webenquiry")->__("Edit Enquiry '%s'", $this->htmlEscape(Mage::registry("webenquiry_data")->getId()));

				} 
				else{

				     return Mage::helper("webenquiry")->__("Add Enquiry");

				}
		}
}