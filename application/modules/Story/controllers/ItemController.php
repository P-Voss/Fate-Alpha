<?php

/**
 * Description of Story_ItemController
 *
 * @author Voß
 */
class Story_ItemController extends Zend_Controller_Action {
    
    /**
     * @var Application_Model_Charakter 
     */
    protected $charakter;
    /**
     * @var Story_Service_Plot
     */
    protected $plotService;
    /**
     * @var Story_Service_Episode
     */
    protected $episodenService;
    
    
    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->plotService = new Story_Service_Plot();
        $this->episodenService = new Story_Service_Episode();
        $this->logService = new Story_Service_Log();
    }

    
}
