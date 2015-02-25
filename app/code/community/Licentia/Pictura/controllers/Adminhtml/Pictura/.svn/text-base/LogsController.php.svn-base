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
class Licentia_Pictura_Adminhtml_Pictura_LogsController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('cms/logs');
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('Pictura'))->_title($this->__('Logs'));
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('pictura/adminhtml_logs'));
        $this->renderLayout();
    }

    public function gridAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('pictura/banners');
        $model->load($id);
        Mage::register('current_banner', $model);
        $this->loadLayout();
        $this->renderLayout();
    }

}
