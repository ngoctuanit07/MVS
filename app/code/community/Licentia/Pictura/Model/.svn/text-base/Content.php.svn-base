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
class Licentia_Pictura_Model_Content extends Mage_Core_Model_Abstract {

    const MYSQL_DATE = 'yyyy-MM-dd';

    protected function _construct() {
        $this->_init('pictura/content');
    }

    public function getSelectedContent($bannerId) {

        $return = $this->getCollection()
                ->addFieldToFilter('banner_id', $bannerId)
                ->getData();

        $content = array();
        foreach ($return as $value) {
            $content[$value['store_id']] = $value;
        }

        return $content;
    }

    public function updateBanner($bannerId, $values, $default) {

        $delete = $this->getCollection()
                ->addFieldToFilter('banner_id', $bannerId);

        foreach ($delete as $item) {
            $item->delete();
        }

        foreach ($default as $key => $value) {
            $values[$key] = $values[0];
        }

        foreach ($values as $key => $value) {
            $data = array();
            $data['banner_id'] = $bannerId;
            $data['store_id'] = $key;
            $data['content'] = $value;
            $data['use_default'] = array_key_exists($key, $default) ? 1 : 0;
            $this->setData($data)->save();
        }
    }

}
