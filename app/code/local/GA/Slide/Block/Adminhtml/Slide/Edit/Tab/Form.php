<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Block_Adminhtml_Slide_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slide_form', array('legend'=>Mage::helper('slide')->__('Slide information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slide')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('slide')->__('Image File'),
          'required'  => false,
          'name'      => 'filename',
	  ));

	  $site = Mage::getResourceModel('core/website_collection');
      $website_array=array();
      foreach($site->getData() as $website){ 
         $website_array[$website['website_id']]=$website['name'];
         $website_array[]=array('value'=>$website['website_id'],'label'=>$website['name']);   
       }
	  
	 $fieldset->addField('website', 'select', array(
          'label'     => Mage::helper('slide')->__('Website'),
          'name'      => 'website',
          'values'    => $website_array,
      ));
	  
	  
	  
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slide')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slide')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slide')->__('Disabled'),
              ),
          ),
      ));
			
			$fieldset->addField('weblink', 'text', array(
          'label'     => Mage::helper('slide')->__('Web Url'),
          'required'  => false,
          'name'      => 'weblink',
      ));
			
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('slide')->__('Content'),
          'title'     => Mage::helper('slide')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
			
     
      if ( Mage::getSingleton('adminhtml/session')->getSlideData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideData());
          Mage::getSingleton('adminhtml/session')->setSlideData(null);
      } elseif ( Mage::registry('slide_data') ) {
          $form->setValues(Mage::registry('slide_data')->getData());
          $p = $form->getElement('filename')->getValue();
	  	  $form->getElement('filename')->setValue('slidebanners/' . $p);
      }
      return parent::_prepareForm();
  }
}