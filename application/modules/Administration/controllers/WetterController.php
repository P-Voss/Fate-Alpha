<?php

/**
 * Description of WetterController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_WetterController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        $service = new Administration_Service_Wetter();
        $this->view->forecast = $service->getOverview($this->getRequest());
        $date = new DateTime();
        if(!is_null($this->getRequest()->getParam('year')) && $this->getRequest()->getParam('year') >= $date->format('Y')){
            $this->view->year = $this->getRequest()->getParam('year');
        }else{
            $this->view->year = $date->format('Y');
        }
    }
    
    public function showAction() {
        $service = new Administration_Service_Wetter();
        $tageswetter = $service->getWeatherForDay($this->getRequest());
        if($tageswetter instanceof Exception){
            $this->redirect('Administration/wetter');
        }
        $this->view->tageswetter = $service->getWeatherForDay($this->getRequest());
    }
    
    public function editAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $service = new Administration_Service_Wetter();
        if($service->editWeather($this->getRequest()) instanceof Exception){
            $this->redirect('Administration/wetter');
        }
        $this->redirect('Administration/wetter');
    }
    
}
