<?php

/**
 * Description of MagieController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_MagieController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
    }
    
    
    public function indexAction() {
        
    }
    
}
