<?php
class Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("enquirymanagement_form", array("legend"=>Mage::helper("enquirymanagement")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("enquirymanagement")->__("Name"),
						"name" => "name",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("enquirymanagement")->__("Email"),
						"name" => "email",
						));
					
						$fieldset->addField("product_id", "text", array(
						"label" => Mage::helper("enquirymanagement")->__("Product"),
						"name" => "product_id",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('post_date', 'date', array(
						'label'        => Mage::helper('enquirymanagement')->__('Post Date'),
						'name'         => 'post_date',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("message", "text", array(
						"label" => Mage::helper("enquirymanagement")->__("Message"),
						"name" => "message",
						));
									
						 $fieldset->addField('website_id', 'select', array(
						'label'     => Mage::helper('enquirymanagement')->__('Website'),
						'values'   => Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Grid::getValueArray6(),
						'name' => 'website_id',
						));

				if (Mage::getSingleton("adminhtml/session")->getEnquirymanagementData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getEnquirymanagementData());
					Mage::getSingleton("adminhtml/session")->setEnquirymanagementData(null);
				} 
				elseif(Mage::registry("enquirymanagement_data")) {
				    $form->setValues(Mage::registry("enquirymanagement_data")->getData());
				}
				return parent::_prepareForm();
		}
}
