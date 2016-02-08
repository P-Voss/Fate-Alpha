<?php

/**
 * Description of InfoController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_InfoController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        
    }
    
}
