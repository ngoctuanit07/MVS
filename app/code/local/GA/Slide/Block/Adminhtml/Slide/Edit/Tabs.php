<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Block_Adminhtml_Slide_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('slide_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('slide')->__('Slide Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('slide')->__('Slide Information'),
          'title'     => Mage::helper('slide')->__('Slide Information'),
          'content'   => $this->getLayout()->createBlock('slide/adminhtml_slide_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}