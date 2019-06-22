<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Nachrichten_IndexController extends Zend_Controller_Action {

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
        $this->service->attach(
            new \Notification\Services\EventListener(
                new \Notification\Services\NotificationFacade()
            )
        );
    }
    
    public function indexAction() {
        $this->redirect('Nachrichten/inbox/');
    }
    
    public function showAction() {
        if($this->getRequest()->getParam('read')){
            $this->service->readMessage($this->getRequest()->getParam('id'));
        }
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        try {
            $nachricht = $this->service->getNachrichtById($this->getRequest()->getParam('id'));
            if ($nachricht->getEmpfaengerId() !== $userId && $nachricht->getVerfasserId() !== $userId) {
                $this->redirect('Nachrichten/inbox/');
            }
            $this->view->nachricht = $nachricht;
        } catch (Exception $exception) {
            $this->redirect('Nachrichten/inbox/');
        }
    }
    
    public function sendAction() {
        $this->service->saveMessage($this->getRequest());
        $this->service->notify();
        $this->redirect('Nachrichten');
    }
    
    public function deleteAction() {
        $this->service->deleteMessage($this->getRequest());
        $this->redirect('Nachrichten');
    }
    
    public function archivAction() {
        $this->view->nachrichten = $this->service->getNachrichtenArchivByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
}
