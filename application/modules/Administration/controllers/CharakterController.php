<?php

/**
 * Description of CharakterController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_CharakterController extends Zend_Controller_Action {

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        
    }
    
}
