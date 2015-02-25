<script type="text/javascript">
function addrequired()
{
	var element = document.getElementById("image");
	if(document.getElementById('image_image') && document.getElementById('image_image').src!='')
	{ }
	else
	{
		element.classList.add("required-entry")
	}
}

setTimeout("addrequired()",1000);

</script>


<?php
class Eshop_Logo_Block_Adminhtml_Logo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("logo_form", array("legend"=>Mage::helper("logo")->__("Logo information")));
								
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('logo')->__('image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						'required' => true,
						));
						
						
						$admin_user_session = Mage::getSingleton('admin/session');
					   	$adminuserId = $admin_user_session->getUser()->getUserId();
					    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
					    $role_name = $role_data['role_name'];
					    $role_id = $role_data['role_id'];
					    //echo "<pre>";print_r($role_data);die;
		      
						
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
						
						
					     $fieldset->addField("website", "select", array(
						"label" => Mage::helper("logo")->__("Website"),					
						'values'   => $website_array,
						"class" => "required-entry",
						"required" => true,
						"name" => "website",
						));
					     
					
				if (Mage::getSingleton("adminhtml/session")->getLogoData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getLogoData());
					Mage::getSingleton("adminhtml/session")->setLogoData(null);
				} 
				elseif(Mage::registry("logo_data")) {
				    $form->setValues(Mage::registry("logo_data")->getData());
				}
				return parent::_prepareForm();
		}
}
