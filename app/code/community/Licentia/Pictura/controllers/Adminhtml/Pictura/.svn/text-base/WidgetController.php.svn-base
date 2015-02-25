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
class Licentia_Pictura_Adminhtml_Pictura_WidgetController extends Mage_Adminhtml_Controller_Action {

    public function chooserAction() {
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $pagesGrid = $this->getLayout()->createBlock('pictura/widget_chooser', '', array(
            'id' => $uniqId,
        ));
        $this->getResponse()->setBody($pagesGrid->toHtml());
    }

}
