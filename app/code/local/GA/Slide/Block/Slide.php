<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Block_Slide extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSlide()     
     { 
        if (!$this->hasData('slide')) {
            $this->setData('slide', Mage::registry('slide'));
        }
        return $this->getData('slide');
        
    }
}