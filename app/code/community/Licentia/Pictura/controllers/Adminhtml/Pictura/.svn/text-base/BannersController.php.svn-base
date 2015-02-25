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
class Licentia_Pictura_Adminhtml_Pictura_BannersController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('cms/banners');

        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('Pictura'))->_title($this->__('Banners'));
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('pictura/adminhtml_banners'));
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

    public function gridcartAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('pictura/banners');
        $model->load($id);
        Mage::register('current_banner', $model);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function gridcatalogAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('pictura/banners');
        $model->load($id);
        Mage::register('current_banner', $model);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__('Pictura'))->_title($this->__('Banners'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('pictura/banners');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('This banner no longer exists.'));
                $this->_redirect('*/*');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Banner'));

        // set entered data if was error when we do save
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        Mage::register('current_banner', $model);

        $this->_initAction();

        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('pictura/adminhtml_banners_edit'))
                ->_addLeft($this->getLayout()->createBlock('pictura/adminhtml_banners_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $data = $this->getRequest()->getPost();
            $data = $this->_filterDates($data, array('date_start', 'date_end'));
            $data['validate'] = true;
            $model = Mage::getModel('pictura/banners');

            $date = Mage::app()->getLocale()->date()->get(Licentia_Pictura_Model_Banners::MYSQL_DATE);

            if ($id) {
                $model->setId($id);
            }

            if (strlen($data['date_start']) == 0) {
                unset($data['date_start']);
            }

            if (strlen($data['date_end']) == 0) {
                unset($data['date_end']);
            }
            $model->addData($data);
            $this->_getSession()->setFormData($model->getData());

            try {
                $model->save();

                if (isset($data['date_start']) && isset($data['date_end']) && $data['date_start'] > $data['date_end']) {
                    throw new Mage_Core_Exception($this->__('The end date cannot be earlier than start date'));
                }
                if (isset($data['date_end']) && $data['date_end'] <= $date) {
                    throw new Mage_Core_Exception($this->__('The end date cannot be earlier than today'));
                }

                $this->_getSession()->addSuccess($this->__('The Banner has been saved.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), 'tab_id' => $this->getRequest()->getParam('tab_id')));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_getSession()->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('An error occurred. Please review the log and try again.'));
                Mage::logException($e);
                $this->_getSession()->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'), 'tab_id' => $this->getRequest()->getParam('tab_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id')) {
            $id = $this->getRequest()->getParam('id');

            try {
                $model = Mage::getModel('pictura/banners');
                $model->setId($id)->delete();

                $this->_getSession()->addSuccess($this->__('Banner was successfully deleted'));

                $this->_redirect('*/*/index');
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('An error occurred. Please review the log and try again.'));
                Mage::logException($e);
                $this->_redirect('*/*/index');
            }
        } else {
            $this->_redirect('*/*/');
        }
    }

}
