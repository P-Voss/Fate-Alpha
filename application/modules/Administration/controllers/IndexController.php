<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_IndexController extends Zend_Controller_Action {

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        
    }
    
}
