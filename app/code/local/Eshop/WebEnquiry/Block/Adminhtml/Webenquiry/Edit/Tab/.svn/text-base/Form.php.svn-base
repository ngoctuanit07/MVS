<?php
class Eshop_WebEnquiry_Block_Adminhtml_Webenquiry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("webenquiry_form", array("legend"=>Mage::helper("webenquiry")->__("Item information")));

				
						$fieldset->addField("name", "label", array(
						"label" => Mage::helper("webenquiry")->__("Name"),
						"name" => "name",
						));
					
						$fieldset->addField("email", "label", array(
						"label" => Mage::helper("webenquiry")->__("Email"),
						"name" => "email",
						));

						$fieldset->addField("subject", "label", array(
						"label" => Mage::helper("webenquiry")->__("Subject"),
						"name" => "email",
						));
						
						
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('post_date', 'label', array(
						'label'        => Mage::helper('webenquiry')->__('Date'),
						'name'         => 'post_date',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						
						$fieldset->addField("message", "label", array(
						"label" => Mage::helper("webenquiry")->__("Message"),
						"name" => "message",
						));
						
						$admin_user_session = Mage::getSingleton('admin/session');
					   	$adminuserId = $admin_user_session->getUser()->getUserId();
					    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
					    $role_name = $role_data['role_name'];
					    $role_id = $role_data['role_id'];
					    
					    $site = Mage::getResourceModel('core/website_collection');
					    $website_array=array();
		
					     if($role_id==1)
					     {
						    	foreach($site->getData() as $website){ 
							         $website_array[]=array('value'=>$website['website_id'],'label'=>$website['name']);   
							     } 		
					     }
					     else
					     {
					     		foreach($site->getData() as $website){
					     		  if($website['name']==$role_name) 
					     		  {
					     		 		$website_array[]=array('value'=>$website['website_id'],'label'=>$website['name']); 
					     		  }
							    }
					     }
						
									
						 $fieldset->addField('website_id', 'select', array(
						'label'     => Mage::helper('webenquiry')->__('Website'),
						'values'   => $website_array,
						'name' => 'website_id',
						'disabled'=>true
						));
						
						$fieldset->addField("reply_message", "textarea", array(
						"label" => Mage::helper("webenquiry")->__("Reply"),
						"name" => "reply_message",
						));
						

				if (Mage::getSingleton("adminhtml/session")->getWebenquiryData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getWebenquiryData());
					Mage::getSingleton("adminhtml/session")->setWebenquiryData(null);
				} 
				elseif(Mage::registry("webenquiry_data")) {
				    $form->setValues(Mage::registry("webenquiry_data")->getData());
				}
				return parent::_prepareForm();
		}
}
