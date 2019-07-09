<?php

/**
 * Description of Circuit
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Circuit
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
    protected $menge;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $kosten;

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
    public function getMenge ()
    {
        return $this->menge;
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
     * @param $menge
     */
    public function setMenge ($menge)
    {
        $this->menge = $menge;
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

}
