<?php	
class Eshop_Merchant_Block_Adminhtml_Merchnat_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "merchant";
				$this->_controller = "adminhtml_merchnat";
				$this->_updateButton("save", "label", Mage::helper("merchant")->__("Save Merchant"));
				$this->_updateButton("delete", "label", Mage::helper("merchant")->__("Delete Merchant"));
				$this->_removeButton('save');
				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("merchant")->__("Save And Continue Edit"),
					"onclick"   => "return onSubContinueEdit(); ",
					"class"     => "save",
				), -100);

				$this->_addButton("savemerchant", array(
					"label"     => Mage::helper("merchant")->__("Save Merchant"),
					"onclick"   => "return onSub();",
					"class"     => "scalable save",
				), -100);
				

				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("merchnat_data") && Mage::registry("merchnat_data")->getId() ){

				    return Mage::helper("merchant")->__("Edit Merchant '%s'", $this->htmlEscape(Mage::registry("merchnat_data")->getId()));

				} 
				else{

				     return Mage::helper("merchant")->__("Add Merchant");

				}
		}
}