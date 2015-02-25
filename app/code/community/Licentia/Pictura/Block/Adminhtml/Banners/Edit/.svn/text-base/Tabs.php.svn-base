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
class Licentia_Pictura_Block_Adminhtml_Banners_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId("pictura_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle($this->__("Banner Information"));
    }

    protected function _beforeToHtml() {

        $this->addTab("main_section", array(
            "label" => $this->__("General"),
            "title" => $this->__("General"),
            "content" => $this->getLayout()->createBlock("pictura/adminhtml_banners_edit_tab_main")->toHtml(),
        ));

        $this->addTab("content_section", array(
            "label" => $this->__("Content"),
            "title" => $this->__("Content"),
            "content" => $this->getLayout()->createBlock("pictura/adminhtml_banners_edit_tab_content")->toHtml(),
        ));

        $this->addTab("cart_section", array(
            "label" => $this->__("Promo Assoc. Cart"),
            "title" => $this->__("Promo Assoc. Cart"),
            "content" => $this->getLayout()->createBlock("pictura/adminhtml_banners_edit_tab_cart")->toHtml(),
        ));

        $this->addTab("catalog_section", array(
            "label" => $this->__("Promo Assoc. Catalog"),
            "title" => $this->__("Promo Assoc. Catalog"),
            "content" => $this->getLayout()->createBlock("pictura/adminhtml_banners_edit_tab_catalog")->toHtml(),
        ));

        if ($this->getRequest()->getParam('tab_id')) {
            $this->setActiveTab($this->getRequest()->getParam('tab_id'));
        }

        return parent::_beforeToHtml();
    }

}
