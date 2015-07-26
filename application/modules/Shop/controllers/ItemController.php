<?php

/**
 * Description of ItemController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_ItemController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
    }
    
    
    public function indexAction() {
    }
    
}
