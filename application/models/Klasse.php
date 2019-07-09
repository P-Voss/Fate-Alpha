<?php

/**
 * Description of Vorteil
 *
 * @author Vosser
 */
class Application_Model_Klasse
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $bezeichnung;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $familienname;
    /**
     * @var string
     */
    protected $kosten;
    /**
     * @var int
     */
    protected $gruppe;


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
    public function getBezeichnung ()
    {
        return $this->bezeichnung;
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
     * @return int
     */
    public function getGruppe ()
    {
        return $this->gruppe;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param $bezeichnung
     */
    public function setBezeichnung ($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
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
     * @param $gruppe
     */
    public function setGruppe ($gruppe)
    {
        $this->gruppe = $gruppe;
    }

    /**
     * @return string
     */
    public function getFamilienname ()
    {
        return $this->familienname;
    }

    /**
     * @param $familienname
     */
    public function setFamilienname ($familienname)
    {
        $this->familienname = $familienname;
    }

}
