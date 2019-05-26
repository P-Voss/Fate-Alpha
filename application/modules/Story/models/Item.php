<?php

/**
 * Description of Story_Model_Item
 *
 * @author Voß
 */
class Story_Model_Item extends Application_Model_Item {

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
     * @return Story_Model_Item
     */
    public function setRequestType ($requestType)
    {
        $this->requestType = $requestType;
        return $this;
    }

}
