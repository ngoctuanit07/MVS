<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Model_Mysql4_Slide extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
       $this->_init('slide/slide', 'slide_id');
    }
}