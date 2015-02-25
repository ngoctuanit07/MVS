<script type="text/javascript">
function addrequired()
{
	var element = document.getElementById("filename");
	if(document.getElementById('filename_image') && document.getElementById('filename_image').src!='')
	{ }
	else
	{
		element.classList.add("required-entry")
	}
}
setTimeout("addrequired()",1000);
</script>

<?php
class Eshop_Slider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("slider_form", array("legend"=>Mage::helper("slider")->__("Slide information")));

				
						$fieldset->addField("title", "text", array(
						"label" => Mage::helper("slider")->__("Title"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "title",
						));
									
						$fieldset->addField('filename', 'image', array(
						'label' => Mage::helper('slider')->__('Filename'),
						'name' => 'filename',
						'note' => '(*.jpg, *.png, *.gif)',
						"required" => true,
						));
						$fieldset->addField("content", "text", array(
						"label" => Mage::helper("slider")->__("Content"),
						"name" => "content",
						));
									
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('slider')->__('Status'),
						'values'   => Eshop_Slider_Block_Adminhtml_Slider_Grid::getValueArray3(),
						'name' => 'status',
						));
						$fieldset->addField("weblink", "text", array(
						"label" => Mage::helper("slider")->__("Weblink"),
						"name" => "weblink",
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
						"label" => Mage::helper("slider")->__("Website"),					
						'values'   => $website_array,
						"class" => "required-entry",
						"required" => true,
						"name" => "website",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getSliderData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getSliderData());
					Mage::getSingleton("adminhtml/session")->setSliderData(null);
				} 
				elseif(Mage::registry("slider_data")) {
				    $form->setValues(Mage::registry("slider_data")->getData());
				 }
				return parent::_prepareForm();
		}
}
