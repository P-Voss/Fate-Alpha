<?php

/**
 * Description of Validation
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Validation
{

    private $_validatorFactory;
    private $_informationFactory;


    public function __construct ()
    {
        $this->_validatorFactory = new Application_Model_Validation_Factory();
        $this->_informationFactory = new Application_Model_Erstellung_Information_InformationFactory();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return string
     */
    public function validateByRequest (Zend_Controller_Request_Http $request)
    {
        $validator = $this->_validatorFactory->getValidator($request->getPost('type'));
        return json_encode(['result' => $validator->validate($request->getPost('value'))]);
    }

    /**
     * @param array $charakterArray
     *
     * @return bool
     */
    public function validateCreation ($charakterArray): bool
    {
        if (!$this->_checkPoints($charakterArray)) {
            return false;
        }
        if (!$this->_checkCombination($charakterArray)) {
            return false;
        }
        return true;
    }

    /**
     * @param array $charakterArray
     *
     * @return bool
     */
    private function _checkPoints ($charakterArray): bool
    {
        $punkte = 0;

        return (30 - $punkte) >= 0;
    }

    /**
     * @param array $charakterArray
     *
     * @return bool
     */
    private function _checkCombination ($charakterArray = []): bool
    {

        return true;
    }

}
