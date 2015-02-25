<?php
class Eshop_Event_Block_Adminhtml_Event_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("event_form", array("legend"=>Mage::helper("event")->__("Item information")));
				
						$fieldset->addField("event_name", "text", array(
						"label" => Mage::helper("event")->__("Event Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "event_name",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);
						

						$fieldset->addField('submittion_start_date', 'date', array(
						'label'        => Mage::helper('event')->__('Submittion Start Date'),
						'name'         => 'submittion_start_date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('submittion_end_date', 'date', array(
						'label'        => Mage::helper('event')->__('Submittion End Date'),
						'name'         => 'submittion_end_date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('publish_start_date', 'date', array(
						'label'        => Mage::helper('event')->__('Publish Start Date'),
						'name'         => 'publish_start_date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('publish_end_date', 'date', array(
						'label'        => Mage::helper('event')->__('Publish End Date'),
						'name'         => 'publish_end_date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("price_per_product", "text", array(
						"label" => Mage::helper("event")->__("Price Per Product"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "price_per_product",
						));
					
						$fieldset->addField("total_items", "text", array(
						"label" => Mage::helper("event")->__("Total Items"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "total_items",
						));
									
						 $fieldset->addField('event_method', 'select', array(
						'label'     => Mage::helper('event')->__('Event Method'),
						'values'   => Eshop_Event_Block_Adminhtml_Event_Grid::getValueArray8(),
						'name' => 'event_method',					
						"class" => "required-entry",
						"required" => true,
						));
						
						$fieldset->addField("position", "text", array(
						"label" => Mage::helper("event")->__("Position"),					
						"name" => "position",
						));
						
						$fieldset->addField("event_description", "textarea", array(
						"label" => Mage::helper("event")->__("Event Description"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "event_description",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getEventData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getEventData());
					Mage::getSingleton("adminhtml/session")->setEventData(null);
				} 
				elseif(Mage::registry("event_data")) {
				    $form->setValues(Mage::registry("event_data")->getData());
				}
				return parent::_prepareForm();
		}
}
