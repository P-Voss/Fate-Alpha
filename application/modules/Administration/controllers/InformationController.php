<?php

/**
 * Description of Administration_InformationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_InformationController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        
    }
    
    public function newAction() {
        
    }
    
    public function deleteAction() {
        
    }
    
    public function createAction() {
        
    }
    
    public function updateAction() {
        
    }
    
}
