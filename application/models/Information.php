<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Application_Model_Information
{

    protected $informationId;
    protected $name;
    protected $kategorie;
    protected $inhalt;
    protected $weitergabe;
    /**
     * @var Application_Model_Requirementlist
     */
    protected $requirementList;


    public function getInformationId ()
    {
        return $this->informationId;
    }

    public function getName ()
    {
        return $this->name;
    }

    public function getInhalt ()
    {
        return $this->inhalt;
    }

    public function getWeitergabe ()
    {
        return $this->weitergabe;
    }

    public function setInformationId ($informationId)
    {
        $this->informationId = $informationId;
    }

    public function setName ($informationName)
    {
        $this->name = $informationName;
    }

    public function setInhalt ($inhalt)
    {
        $this->inhalt = $inhalt;
    }

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

    public function setRequirementList (Application_Model_Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

    public function getKategorie ()
    {
        return $this->kategorie;
    }

    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

}
