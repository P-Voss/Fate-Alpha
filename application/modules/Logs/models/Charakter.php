<?php

namespace Logs\Models;

use Application_Model_Interfaces_CharakterResult;

/**
 * Description of Charakter
 *
 * @author Voß
 */
class Charakter extends \Application_Model_Charakter
{

    /**
     * @var Application_Model_Interfaces_CharakterResult
     */
    protected $result;

    /**
     * @return Application_Model_Interfaces_CharakterResult
     */
    public function getResult ()
    {
        return $this->result;
    }

    /**
     * @param Application_Model_Interfaces_CharakterResult $result
     */
    public function setResult (Application_Model_Interfaces_CharakterResult $result)
    {
        $this->result = $result;
    }

}
