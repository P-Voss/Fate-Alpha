<?php

/**
 * Description of OutboxController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Nachrichten_OutboxController extends Zend_Controller_Action {

    /**
     * @var Nachrichten_Service_Nachrichten
     */
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
        if((int) $this->getRequest()->getParam('wish') > 0){
            $this->forward('wish');
//            $nachricht = $this->service->getNachrichtById($this->getRequest()->getParam('id'));
//            if($nachricht->getAdmin() !== true){
//                $this->view->respondTo = $nachricht;
//            }
        }
    }


    public function wishAction() {
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $service = new \Feedback\Services\WishService();
        $this->view->wish = $service->load($this->getRequest()->getParam('wish'));
    }
    
}
