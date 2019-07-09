<?php

/**
 * Description of Luck
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Luck
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $kategorie;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $kosten;
    /**
     * @var boolean
     */
    protected $modified;
    /**
     * @var int
     */
    protected $modification = 0;


    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKategorie ()
    {
        return $this->kategorie;
    }

    /**
     * @return string
     */
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return string
     */
    public function getKosten ()
    {
        return $this->kosten;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param $kategorie
     */
    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $kosten
     */
    public function setKosten ($kosten)
    {
        $this->kosten = $kosten;
    }

    /**
     * @return bool
     */
    public function getModified ()
    {
        return $this->modified === true;
    }

    /**
     * @param $modified
     */
    public function setModified ($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return int
     */
    public function getModification ()
    {
        return $this->modification;
    }

    /**
     * @param $modification
     */
    public function setModification ($modification)
    {
        $this->modification += $modification;
    }

}
