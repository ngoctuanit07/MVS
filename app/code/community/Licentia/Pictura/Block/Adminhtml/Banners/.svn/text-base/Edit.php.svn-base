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
class Licentia_Pictura_Block_Adminhtml_Banners_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = "banner_id";
        $this->_blockGroup = "pictura";
        $this->_controller = "adminhtml_banners";

        $this->_addButton("saveandcontinue", array(
            "label" => $this->__("Save and Continue Edit"),
            "onclick" => "saveAndContinueEdit()",
            "class" => "save",
                ), -100);

        $this->_formScripts[] = " function saveAndContinueEdit() {
                    tabID = '';
                    $$('ul.tabs li a.active').each(function (item) {
                         tabID = item.readAttribute('name');
                    })
                editForm.submit($('edit_form').action+'back/edit/tab_id/'+tabID);
            }";

    }

    public function getHeaderText()
    {
        if (Mage::registry("current_banner")->getId()) {
            return $this->__("Edit Banner '%s'", $this->htmlEscape(Mage::registry("current_banner")->getName()));
        } else {
            return $this->__("Add Banner");
        }
    }

}
