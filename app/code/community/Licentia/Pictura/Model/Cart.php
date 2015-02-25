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
class Licentia_Pictura_Model_Cart extends Mage_Core_Model_Abstract {

    const MYSQL_DATE = 'yyyy-MM-dd';

    protected function _construct() {
        $this->_init('pictura/cart');
    }

    public function getSelectedCartIds($bannerId) {

        return $this->getCollection()
                        ->addFieldToFilter('banner_id', $bannerId)
                        ->getAllIds('promo_id');
    }

    public function updateBanner($bannerId, $values) {

        $delete = $this->getCollection()
                ->addFieldToFilter('banner_id', $bannerId);

        foreach ($delete as $item) {
            $item->delete();
        }

        foreach ($values as $value) {
            $data = array();
            $data['banner_id'] = $bannerId;
            $data['promo_id'] = $value;
            $this->setData($data)->save();
        }
    }

}
