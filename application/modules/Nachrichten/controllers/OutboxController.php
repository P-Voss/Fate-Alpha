<?php

/**
 * Description of OutboxController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Nachrichten_OutboxController extends Zend_Controller_Action {

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
        $this->view->nachrichten = $this->service->getNachrichtenSentByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
    public function newAction() {
        $userService = new Application_Service_User();
        $this->view->users = $userService->getUsers();
        if($this->getRequest()->getParam('id') !== null){
            $nachricht = $this->service->getNachrichtById($this->getRequest()->getParam('id'));
            if($nachricht->getAdmin() !== true){
            $this->view->respondTo = $nachricht;
            }
        }
    }
    
}
