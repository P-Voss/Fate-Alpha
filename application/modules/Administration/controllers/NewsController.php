<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_NewsController extends Zend_Controller_Action {

    protected $_userService;
    protected $_layoutService;
    protected $_newsService;
    protected $_charakterService;

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
        $this->_newsService = new Administration_Service_News();
        $this->_charakterService = new Application_Service_Charakter();
    }
    
    public function newAction() {
        
    }
    
    public function showAction() {
        $this->view->news = $this->_newsService->getNewsById(
            $this->getRequest()->getParam('id')
        );
    }
    
    public function indexAction() {
        $this->view->newsList = $this->_newsService->getNewsList();
    }
    
    public function createAction() {
        $this->_newsService->createNews($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration/news');
    }
    
    public function editAction() {
        $this->_newsService->editNews($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration/news');
    }
    
    public function deleteAction() {
        $this->_newsService->deleteNews($this->getRequest());
        $this->redirect('Administration/news');
    }
    
}
