<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Model_System_Config_Styles 
{
    public function toOptionArray()
    {
        return array(
		    array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('fade')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('linear')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('random')),
		   
        );
    }
	
}

