<?php

/**
 * Description of Story_Model_Charakter
 *
 * @author Voß
 */
class Story_Model_Charakter extends Application_Model_Charakter
{

    /**
     * @var
     */
    protected $datenFreigabe;
    /**
     * @var
     */
    protected $involved;
    /**
     * @var
     */
    protected $result;


    /**
     * @return bool
     */
    public function getDatenFreigabe ()
    {
        return $this->datenFreigabe !== null ? $this->datenFreigabe : false;
    }

    /**
     * @param $datenFreigabe
     */
    public function setDatenFreigabe ($datenFreigabe)
    {
        $this->datenFreigabe = $datenFreigabe;
    }

    /**
     * @return bool
     */
    public function getInvolved ()
    {
        return $this->involved !== null ? $this->involved : false;
    }

    /**
     * @param $involved
     */
    public function setInvolved ($involved)
    {
        $this->involved = $involved;
    }

    /**
     * @return Story_Model_CharakterResult
     */
    public function getResult ()
    {
        return $this->result;
    }

    /**
     * @param Story_Model_CharakterResult $result
     */
    public function setResult (Story_Model_CharakterResult $result)
    {
        $this->result = $result;
    }

}
