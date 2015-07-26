<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_SkillController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->logincheck();
    }
    
    
    public function indexAction() {
        
    }
    
}
