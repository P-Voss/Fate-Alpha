<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Application_Model_Information
{

    /**
     * @var int
     */
    protected $informationId;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $kategorie;
    /**
     * @var string
     */
    protected $inhalt;
    /**
     * @var string
     */
    protected $weitergabe;
    /**
     * @var Application_Model_Requirementlist
     */
    protected $requirementList;


    /**
     * @return int
     */
    public function getInformationId ()
    {
        return $this->informationId;
    }

    /**
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getInhalt ()
    {
        return $this->inhalt;
    }

    /**
     * @return string
     */
    public function getWeitergabe ()
    {
        return $this->weitergabe;
    }

    /**
     * @param $informationId
     */
    public function setInformationId ($informationId)
    {
        $this->informationId = $informationId;
    }

    /**
     * @param $informationName
     */
    public function setName ($informationName)
    {
        $this->name = $informationName;
    }

    /**
     * @param $inhalt
     */
    public function setInhalt ($inhalt)
    {
        $this->inhalt = $inhalt;
    }

    /**
     * @param $weitergabe
     */
    public function setWeitergabe ($weitergabe)
    {
        $this->weitergabe = $weitergabe;
    }

    /**
     * @return Application_Model_Requirementlist
     */
    public function getRequirementList ()
    {
        return $this->requirementList;
    }

    /**
     * @param Application_Model_Requirementlist $requirementList
     */
    public function setRequirementList (Application_Model_Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

    /**
     * @return string
     */
    public function getKategorie ()
    {
        return $this->kategorie;
    }

    /**
     * @param $kategorie
     */
    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

}
