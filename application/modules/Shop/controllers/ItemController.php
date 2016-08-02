<?php

/**
 * Description of ItemController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_ItemController extends Zend_Controller_Action {

    public function init(){
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }
    
    
    public function indexAction() {
        
    }
    
}
