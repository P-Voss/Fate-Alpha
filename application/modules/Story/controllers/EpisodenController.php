<?php

/**
 * Description of Story_EpisodenController
 *
 * @author Voß
 */
class Story_EpisodenController extends Zend_Controller_Action {
    
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }
    
    
    
    
}
