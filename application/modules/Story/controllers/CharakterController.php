<?php

/**
 * Description of CharakterController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Story_CharakterController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter 
     */
    protected $charakterService;

    /**
     * @var Story_Service_Plot
     */
    protected $plotService;
    
    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->plotService = new Story_Service_Plot();
    }
    
    public function indexAction() {
        $this->redirect('Story/plots/show/id/' . $this->getRequest()->getParam('plot'));
    }
    
    
    public function removeAction() {
        if((int)$this->getRequest()->getParam('plot') <= 0
                ||
            (int)$this->getRequest()->getParam('charakter') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('plot');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->plotService->removeParticipant((int)$this->getRequest()->getParam('charakter'), $plotId);
        $this->redirect('Story/plots/sl/id/' . $this->getRequest()->getParam('plot'));
    }
    
    public function showAction() {
        if($this->plotService->isSL($this->getRequest()->getParam('plot'), Zend_Auth::getInstance()->getIdentity()->userId)
            && $this->plotService->checkDatenfreigabeCharakter($this->getRequest()->getParam('plot'), $this->getRequest()->getParam('charakter')))
        {
            $charakter = $this->charakterService->getCharakterById($this->getRequest()->getParam('charakter', 0));
            $this->view->charakter = $charakter;

            $magieService = new Shop_Service_Magie();
            $this->view->magieschulen = $magieService->getSchoolsByCharacter($charakter->getCharakterid());
            $this->view->magien = $charakter->getMagien();

            $skillService = new Shop_Service_Skill();
            $skillarten = $skillService->getSkillArtenForCharakter($charakter);
            foreach ($skillarten as $skillart) {
                if($skillart->getLearned() === false){
                    unset($skillart);
                }else{
                    $skillart->setSkills($skillService->getLearnedSkillBySkillart($charakter->getCharakterid(), $skillart));
                }
            }
            $this->view->skillarten = $skillarten;
        }elseif(!is_null($this->getRequest()->getParam('plot'))){
            $this->redirect('Story/plots/sl/id/' . $this->getRequest()->getParam('plot'));
        }else{
            $this->redirect('Story');
        }
    }
    
    
    public function freigabeAction() {
        if((int)$this->getRequest()->getParam('plotId') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('plotId');
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if(!$this->plotService->isPlayer($plotId, $userId)){
            $this->redirect('index');
        }
        $this->plotService->updateFreigabe($this->getRequest()->getPost('freigabe', 0), $userId, $plotId);
        $this->redirect('Story/plots/show/id/' . $plotId);
    }
    
}
