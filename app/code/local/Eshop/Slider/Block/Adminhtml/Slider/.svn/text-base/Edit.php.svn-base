<?php
	
class Eshop_Slider_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "slide_id";
				$this->_blockGroup = "slider";
				$this->_controller = "adminhtml_slider";
				$this->_updateButton("save", "label", Mage::helper("slider")->__("Save Slide"));
				$this->_updateButton("delete", "label", Mage::helper("slider")->__("Delete Slide"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("slider")->__("Save And Continue Edit"),
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
				if( Mage::registry("slider_data") && Mage::registry("slider_data")->getId() ){

				    return Mage::helper("slider")->__("Edit Slide '%s'", $this->htmlEscape(Mage::registry("slider_data")->getId()));

				} 
				else{

				     return Mage::helper("slider")->__("Add Slide");

				}
		}
}