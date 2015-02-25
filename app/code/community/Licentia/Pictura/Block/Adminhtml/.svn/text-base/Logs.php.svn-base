<?php

/**
 * Licentia Pictura - Banner Management
 *
 * NOTICE OF LICENSE
 * This source file is subject to the European Union Public Licence
 * It is available through the world-wide-web at this URL:
 * http://joinup.ec.europa.eu/software/page/eupl/licence-eupl
 *
 * @title      Background Management
 * @category   Marketing
 * @package    Licentia
 * @author     Bento Vilas Boas <bento@licentia.pt>
 * @copyright  Copyright (c) 2014 Licentia - http://licentia.pt
 * @license    European Union Public Licence
 */
class Licentia_Pictura_Block_Adminhtml_Logs extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $id = $this->getRequest()->getParam('id');
        $banner = Mage::getModel('pictura/banners')->load($id);

        $this->_controller = 'adminhtml_logs';
        $this->_blockGroup = 'pictura';
        $this->_headerText = $this->__('Banner Log' . ' / ' . $banner->getName());
        parent::__construct();

        $urlTypes = $this->getUrl('*/pictura_banners/');
        $data = array('label' => $this->__('Back to Banners'), 'onclick' => "window.location='$urlTypes'", 'class' => 'back');
        $this->_addButton('types', $data, 0, 1);

        $this->_removeButton('add');
    }

}
