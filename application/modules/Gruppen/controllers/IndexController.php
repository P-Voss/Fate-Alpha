<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Gruppen_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Service_Charakter
     */
    protected $charakterService;

    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;

    /**
     * @var Gruppen_Service_Gruppen
     */
    protected $gruppenService;

    protected $auth;

    public function init ()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->gruppenService = new Gruppen_Service_Gruppen();
        $this->gruppenService->attach(
            new \Notification\Services\EventListener(
                new \Notification\Services\NotificationFacade()
            )
        );
        $this->charakterService = new Application_Service_Charakter();

        if ($this->_helper->logincheck() === false) {
            $this->redirect('index');
        }
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        try {
            $this->charakter = $this->charakterService->getCharakterByUserid($this->auth->userId);
        } catch (Exception $exception) {
            $this->charakter = false;
        }
    }

    public function indexAction ()
    {
        if ($this->charakter !== false) {
            $this->view->gruppen = $this->gruppenService->getGruppenByCharakterId($this->charakter->getCharakterId());
        } else {
            $this->view->gruppen = [];
        }
        $this->view->eigeneGruppen = $this->gruppenService->getGruppenByLeaderId($this->auth->userId);
    }

    public function createAction ()
    {
        $this->gruppenService->createGruppe($this->getRequest());
        $this->redirect('Gruppen');
    }

    public function enterAction ()
    {
        $this->gruppenService->joinGruppe($this->getRequest(), $this->charakter->getCharakterid());
        $this->redirect('Gruppen');
    }

    public function exitAction ()
    {
        $this->gruppenService->leaveGroup($this->getRequest()->getPost('gruppenId'), $this->charakter->getCharakterid());
        $this->redirect('Gruppen');
    }

    public function showAction ()
    {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        $gruppenId = (int)$this->getRequest()->getParam('id', 0);
        if (!$this->gruppenService->validateAccess(
            $gruppenId,
            $charakterId,
            $this->auth->userId
        )) {
            $this->redirect('Gruppen');
        }

        $gruppe = $this->gruppenService->getGruppeByGruppenId($gruppenId);
        if ($gruppe === false) {
            $this->redirect('Gruppen');
        }
        $this->view->eigeneGruppe = ($gruppe->getGruender() === $this->auth->userId);
        $this->view->exposed = $this->gruppenService->dataExposed($gruppenId, $charakterId);
        $this->view->exposedIds = $this->gruppenService->getExposedIds($gruppenId);
        $this->view->gruppe = $gruppe;
        $this->view->charaktere = $this->charakterService->getCharakters();
        $this->view->gruppenchat = $this->gruppenService->getGruppenchat($gruppenId);
    }

    public function addAction ()
    {
        if (!$this->gruppenService->isLeader($this->auth->userId, $this->getRequest()->getParam('gruppenId'))) {
            $this->redirect('Gruppen');
        }
        if (!is_null($this->getRequest()->getParam('gruppenId'))) {
            $this->gruppenService->addToGroup($this->getRequest(), $this->auth->userId);
            $this->gruppenService->notify();
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        } else {
            $this->redirect('Gruppen');
        }
    }

    public function editAction ()
    {
        if (!$this->gruppenService->isLeader($this->auth->userId, $this->getRequest()->getPost('gruppenId'))) {
            $this->redirect('Gruppen');
        }
        if (!is_null($this->getRequest()->getPost('gruppenId'))) {
            $this->gruppenService->editGruppe($this->getRequest());
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getPost('gruppenId'));
        } else {
            $this->redirect('Gruppen');
        }
    }

    public function removeAction ()
    {
        if (!$this->gruppenService->isLeader($this->auth->userId, $this->getRequest()->getParam('gruppenId'))) {
            $this->redirect('Gruppen');
        }
        if (!is_null($this->getRequest()->getParam('gruppenId'))) {
            $this->gruppenService->removeFromGroup($this->getRequest(), $this->auth->userId);
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        } else {
            $this->redirect('Gruppen');
        }
    }

    public function chatAction ()
    {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        if (!$this->gruppenService->validateAccess(
            $this->getRequest()->getParam('gruppenId'),
            $charakterId,
            $this->auth->userId
        )) {
            $this->redirect('Gruppen');
        }

        if (!is_null($this->getRequest()->getParam('gruppenId'))) {
            $this->gruppenService->addNachricht($this->getRequest(), $this->auth->userId);
            $this->gruppenService->notify();
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        } else {
            $this->redirect('Gruppen');
        }
    }

}
