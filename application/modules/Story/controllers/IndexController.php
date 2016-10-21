<?php

/**
 * Description of Story_IndexController
 *
 * @author Voß
 */
class Story_IndexController extends Zend_Controller_Action {
    
    /**
     * @var Story_Service_Plot
     */
    private $plotService;
    
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->plotService = new Story_Service_Plot();
    }
    
    
    public function indexAction() {
        $gruppenService = new Gruppen_Service_Gruppen();
        $this->view->eigeneGruppen = $gruppenService->getGruppenByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->view->plots = $this->plotService->getPlotsBySLId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
}
