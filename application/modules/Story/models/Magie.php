<?php

/**
 * Description of Story_Model_Magie
 *
 * @author Voß
 */
class Story_Model_Magie extends Application_Model_Magie {

    /**
     * @var string
     */
    private $requestType;

    /**
     * @return string
     */
    public function getRequestType ()
    {
        return $this->requestType;
    }

    /**
     * @param string $requestType
     *
     * @return Story_Model_Magie
     */
    public function setRequestType ($requestType)
    {
        $this->requestType = $requestType;
        return $this;
    }

    /**
     * @return  string
     */
    public function __toString ()
    {
        return $this->bezeichnung;
    }
    
}
