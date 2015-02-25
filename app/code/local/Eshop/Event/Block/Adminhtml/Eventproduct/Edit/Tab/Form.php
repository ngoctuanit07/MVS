<?php
class Eshop_Event_Block_Adminhtml_Eventproduct_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("event_form", array("legend"=>Mage::helper("event")->__("Item information")));

						//echo "<pre>";print_r(Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getValueArray14());die;
						//$data_array[]=array('value'=>$k,'label'=>$v);
						$data_array=array();
						$collection = Mage::getModel("event/event")->getCollection();
						foreach ($collection as $coll=>$value)
						{
							//$data_array[$value->getEventName()]=$value->getEventName();
							$data_array[]=array('value'=>$value->getId(),'label'=>$value->getEventName());
						}
						
						$fieldset->addField("event_name", "select", array(
						"label" => Mage::helper("event")->__("Event Name"),					
						'values'   => $data_array,
						"class" => "required-entry",
						"required" => true,
						"name" => "event_name",
						));
					
						$fieldset->addField("sku", "text", array(
						"label" => Mage::helper("event")->__("Product Sku"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "sku",
						));

						/*
						$fieldset->addField("merchant_website", "text", array(
						"label" => Mage::helper("event")->__("Merchant Website"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "merchant_website",
						));
									
						 $fieldset->addField('event_method', 'select', array(
						'label'     => Mage::helper('event')->__('Event Method'),
						'values'   => Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getValueArray13(),
						'name' => 'event_method',					
						"class" => "required-entry",
						"required" => true,
						));
						*/
						//echo "<pre>";
						//print_r(Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getValueArray14());die;
						
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('event')->__('Status'),
						'values'   => Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getValueArray14(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getEventproductData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getEventproductData());
					Mage::getSingleton("adminhtml/session")->setEventproductData(null);
				} 
				elseif(Mage::registry("eventproduct_data")) {
					//echo "<pre>";print_r(Mage::registry("eventproduct_data")->getData());die;
					$form->setValues(Mage::registry("eventproduct_data")->getData());
				}
				return parent::_prepareForm();
		}
}
