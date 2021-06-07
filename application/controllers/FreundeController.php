<?php

/**
 * Description of FreundeController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class FreundeController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter
     */
    protected $_charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $_layoutService;
    /**
     * @var Application_Service_User
     */
    protected $_userService;
    /**
     * @var Application_Model_Charakter
     */
    protected $character;


    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_charakterService = new Application_Service_Charakter();
        $this->_layoutService = new Application_Service_Layout();
        $this->_userService = new Application_Service_User();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null || !$this->_userService->hasChara($auth->userId)){
            $this->redirect('index');
        }  else {
            try {
                $this->character = $this->_charakterService->getCharakterByUserid($auth->userId);
                $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
                $layout->setLayout('online');
            } catch (Throwable $exception) {
                $this->redirect('Erstellung/creation');
            }
        }
    }

    public function indexAction() {
        $this->view->ownCharacter = $this->character;
        $this->view->profile = $this->_charakterService->getProfile($this->character->getCharakterid());
        $this->view->friendlist = $this->_charakterService->getAssociates($this->character->getCharakterid());
    }
    
    public function previewAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper-> viewRenderer-> setNoRender();
        $preview = $this->_charakterService->getPreview($this->getRequest()->getPost('id'));
        echo $preview;
    }
    
    public function addAction() {
        $this->_charakterService->addAssociate($this->getRequest(), $this->character->getCharakterid());
        $this->redirect('freunde');
    }
    
    public function profilAction() {
        $valid = false;
        if($this->getRequest()->getParam('charakter') === null){
            $this->redirect('freunde');
        }
        try {
            $charakter = $this->_charakterService->getCharakterByUUID($this->getRequest()->getParam('charakter', 0));
            if($charakter->getCharakterid() === $this->character->getCharakterid()){
                $valid = true;
            }
            if($charakter->getCharakterid() !== null && $this->_charakterService->isAssociated($this->character, $charakter)) {
                $charakter->setCharakterprofil(
                    $this->_charakterService->getVisibleProfile(
                        $charakter->getCharakterid(),
                        $this->character->getCharakterid()
                    )
                );
                $valid = true;
            }
            $this->view->charakter = $charakter;
            if($valid === false){
                $this->redirect('freunde');
            }
        } catch (Exception $exception) {
            $this->redirect('freunde');
        }
    }
    
    public function passAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
        $charakter = $this->_charakterService->getCharakterByUUID($this->getRequest()->getParam('charakter', 0));
        if($charakter->getCharakterid() !== null && 
                ($this->_charakterService->isAssociated($this->character, $charakter)
                    || $charakter->getCharakterid() === $this->character->getCharakterid()
                )
            ) {
            $charakter->setCharakterprofil($this->_charakterService->getVisibleProfile(
                $charakter->getCharakterid(),
                $this->character->getCharakterid())
            );
            if($charakter->getCharakterid() === $this->character->getCharakterid()){
                $charakter->setCharakterprofil($this->_charakterService->getProfile($charakter->getCharakterid()));
            }
            $this->view->charakter = $charakter;
        } else {
            $this->view->charakter = null;
        }
    }

}
