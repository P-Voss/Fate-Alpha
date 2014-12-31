<?php

/**
 * Description of Validation
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Validation {
    
    private $_validatorFactory;


    public function __construct() {
        $this->_validatorFactory = new Application_Model_Validation_Factory();
    }
    
    public function validateByRequest(Zend_Controller_Request_Http $request) {
        $validator = $this->_validatorFactory->getValidator($request->getPost('type'));
        return $validator->validate($request->getPost('value'));
    }
    
}
