<?php

/**
 * Description of Administration_Model_Information
 *
 * @author Vosser
 */
class Administration_Model_Information implements Administration_Model_CrudObject
{

    protected $informationId;
    protected $name;
    protected $kategorie;
    protected $inhalt;
    protected $weitergabe;
    /**
     * @var Administration_Model_Requirementlist
     */
    protected $requirementList;

    /**
     * @var
     */
    private $creator;
    /**
     * @var
     */
    private $editor;
    /**
     * @var DateTime
     */
    private $createDate;
    /**
     * @var DateTime
     */
    private $editDate;


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

    public function getKategorie ()
    {
        return $this->kategorie;
    }

    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

    /**
     * @return mixed
     */
    public function getCreator ()
    {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getEditor ()
    {
        return $this->editor;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getCreateDate ($format = 'd.m.Y H:i')
    {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getEditDate ($format = 'd.m.Y H:i')
    {
        $date = new DateTime($this->editDate);
        return $date->format($format);
    }

    /**
     * @param $creator
     */
    public function setCreator ($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @param $editor
     */
    public function setEditor ($editor)
    {
        $this->editor = $editor;
    }

    /**
     * @param $createDate
     */
    public function setCreateDate ($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @param $editDate
     */
    public function setEditDate ($editDate)
    {
        $this->editDate = $editDate;
    }

    /**
     * @return Administration_Model_Requirementlist
     */
    public function getRequirementList ()
    {
        if ($this->requirementList === null) {
            return new Administration_Model_Requirementlist();
        }
        return $this->requirementList;
    }

    /**
     * @param Administration_Model_Requirementlist $requirementList
     */
    public function setRequirementList (Administration_Model_Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

}
