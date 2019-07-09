<?php

/**
 * Description of Element
 *
 * @author Vosser
 */
class Application_Model_Element
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
    protected $charakterisierung;
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
    public function getCharakterisierung ()
    {
        return $this->charakterisierung;
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
     * @param $charakterisierung
     */
    public function setCharakterisierung ($charakterisierung)
    {
        $this->charakterisierung = $charakterisierung;
    }

    /**
     * @param $kosten
     */
    public function setKosten ($kosten)
    {
        $this->kosten = $kosten;
    }

}
