<?php

/**
 * Description of Story_PlotsController
 *
 * @author Voß
 */
class Story_PlotsController extends Zend_Controller_Action
{

    /**
     * @var Story_Service_Plot
     */
    protected $plotService;
    /**
     * @var Story_Service_Episode
     */
    protected $episodenService;


    public function init ()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if ($this->_helper->logincheck() === false) {
            $this->redirect('index');
        }
        $this->plotService = new Story_Service_Plot();
        $this->episodenService = new Story_Service_Episode();
    }


    public function newAction ()
    {
        $gruppenService = new Gruppen_Service_Gruppen();
        $this->view->eigeneGruppen = $gruppenService->getGruppenByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }


    public function createAction ()
    {
        if (!is_null($this->getRequest()->getPost('gruppenId'))) {
            $this->plotService->createStoryline($this->getRequest());
            $this->redirect('Story');
        } else {
            $this->redirect('Gruppen');
        }
    }


    public function showAction ()
    {
        if ((int)$this->getRequest()->getParam('id') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('id');
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if (!$this->plotService->isPlayer($plotId, $userId)) {
            if ($this->plotService->isSL($plotId, $userId)) {
                $this->redirect('Story/plots/sl/id/' . $plotId);
            } else {
                $this->redirect('index');
            }
        }
        $this->view->plot = $this->plotService->getPlotById($plotId);
        $this->view->episodes = $this->episodenService->getEpisodesByPlotIdForUser($plotId, $userId);
        $this->view->freigabe = $this->plotService->checkDatenfreigabe($plotId, $userId);
        $this->view->participants = [];
        $this->view->invitables = [];
    }

    public function slAction ()
    {
        if ((int)$this->getRequest()->getParam('id') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('id');
        if (!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)) {
            $this->redirect('index');
        }
        $this->view->plot = $this->plotService->getPlotById((int)$this->getRequest()->getParam('id'));
        $this->view->episodes = $this->episodenService->getEpisodesByPlotId($plotId);
        $this->view->participants = $this->plotService->getParticipantsByPlotId($plotId);
        $this->view->invitables = $this->plotService->getPossibleParticipants($plotId);
    }


    public function editAction ()
    {
        if ((int)$this->getRequest()->getPost('plotId') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if (!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)) {
            $this->redirect('index');
        }
        $this->plotService->editPlot($this->getRequest());
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }


    public function deleteAction ()
    {
        if ((int)$this->getRequest()->getPost('plotId') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if (!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)) {
            $this->redirect('index');
        }
        $episodeService = new Story_Service_Episode();
        if (count($episodeService->getActiveEpisodesByPlotId($plotId)) > 0) {
            $this->redirect('Story/plots/sl/id/' . $plotId);
        } else {
            $this->plotService->deletePlot($plotId);
            $this->redirect('Story');
        }
    }


    public function addAction ()
    {
        if ((int)$this->getRequest()->getPost('plotId') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if (!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)) {
            $this->redirect('index');
        }
        $invitables = $this->plotService->getPossibleParticipants($plotId);
        $invitableIds = [];
        foreach ($invitables as $charakter) {
            $invitableIds[] = $charakter->getCharakterId();
        }
        $invites = array_intersect($invitableIds, $this->getRequest()->getPost('invites'));
        $this->plotService->addParticipants($plotId, $invites);
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }

    public function removeAction ()
    {
        if ((int)$this->getRequest()->getPost('plotId') <= 0) {
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if (!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)) {
            $this->redirect('index');
        }
        //        $this->plotService->removeParticipant($plotId, (int)$this->getRequest()->getPost('charakterId'));
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }

}
