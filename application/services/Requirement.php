<?php

/**
 * Description of Requirement
 *
 * @author Voß
 */
class Application_Service_Requirement
{

    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Application_Model_Requirements_Factory
     */
    private $factory;

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function __construct (Application_Model_Charakter $charakter = null)
    {
        if ($charakter !== null) {
            $this->charakter = $charakter;
        }
        $this->factory = new Shop_Model_Requirements_Factory();
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter (Application_Model_Charakter $charakter)
    {
        $this->charakter = $charakter;
    }

}
