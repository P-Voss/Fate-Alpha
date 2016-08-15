<?php

/**
 * Description of InboxController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Nachrichten_InboxController extends Zend_Controller_Action {

    private $service;
    
    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Nachrichten_Service_Nachrichten();
    }
    
    public function indexAction() {
        $this->view->nachrichten = $this->service->getNachrichtenReceivedByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
}
