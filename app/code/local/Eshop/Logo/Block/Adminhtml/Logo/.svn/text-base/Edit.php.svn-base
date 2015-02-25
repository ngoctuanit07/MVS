<?php
	
class Eshop_Logo_Block_Adminhtml_Logo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "logo";
				$this->_controller = "adminhtml_logo";
				$this->_updateButton("save", "label", Mage::helper("logo")->__("Save Logo"));
				$this->_updateButton("delete", "label", Mage::helper("logo")->__("Delete Logo"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("logo")->__("Save And Continue Edit"),
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
				if( Mage::registry("logo_data") && Mage::registry("logo_data")->getId() ){

				    return Mage::helper("logo")->__("Edit Logo '%s'", $this->htmlEscape(Mage::registry("logo_data")->getId()));

				} 
				else{

				     return Mage::helper("logo")->__("Add Logo");

				}
		}
}