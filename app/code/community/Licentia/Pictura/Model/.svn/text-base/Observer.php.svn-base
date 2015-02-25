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
class Licentia_Pictura_Model_Observer {

    public function startConversion() {
        $session = Mage::getSingleton('customer/session');

        $paramName = Mage::getStoreConfig('pictura/config/param');
        $request = Mage::app()->getRequest();
        $bannerId = $request->getParam($paramName);

        if ($session->getPicturaConversion() == $bannerId) {
            return false;
        }

        $banner = Mage::getModel('pictura/banners')->load($bannerId, 'code');
        if ($banner->getId()) {
            $session = Mage::getSingleton('customer/session');
            $session->setPicturaConversion($bannerId);
            $banner->setData('clicks', $banner->getData('clicks') + '1')->save();

            $data = array();
            $data['created_at'] = now();
            $data['banner_id'] = $banner->getId();
            $data['type'] = 'click';
            $data['store_id'] = Mage::app()->getStore()->getId();

            Mage::getModel('pictura/logs')->setData($data)->save();
        }

        $request->setParam($paramName, null);
    }

    public function afterOrder($event) {
        $session = Mage::getSingleton('customer/session');
        if (!$session->getPicturaConversion()) {
            return false;
        }

        $banner = Mage::getModel('pictura/banners')->load($session->getPicturaConversion(), 'code');

        if (!$banner->getId()) {
            return false;
        }

        $order = $event->getEvent()->getOrder();

        $data = array();
        $data['created_at'] = now();
        $data['banner_id'] = $banner->getId();
        $data['type'] = 'conversion';
        $data['order_id'] = $order->getId();
        $data['store_id'] = Mage::app()->getStore()->getId();

        Mage::getModel('pictura/logs')->setData($data)->save();
        $banner->setData('conversions_number', $banner->getData('conversions_number') + 1)
                ->setData('conversions_amount', $banner->getData('conversions_amount') + $order->getBaseGrandTotal())
                ->save();
    }

}
