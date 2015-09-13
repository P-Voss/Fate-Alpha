<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_SkillController extends Zend_Controller_Action {
    
    /**
     * @var Application_Model_Charakter;
     */
    private $charakter;
    /**
     * @var Application_Service_Charakter;
     */
    private $charakterService;

    public function init(){
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $this->charakterService = new Application_Service_Charakter();
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
        if($this->charakter === false){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }
    
    public function indexAction() {
        $service = new Shop_Service_Skill();
        $skillArten = $service->getSkillArtenForCharakter($this->charakter);
    }
    
}
