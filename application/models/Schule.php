<?php

/**
 * Description of Schule
 *
 * @author Vosser
 */
class Application_Model_Schule
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
     * @var int
     */
    protected $kosten;
    /**
     * @var Application_Model_Magie[]
     */
    protected $magien = [];

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
     * @return int
     */
    public function getKosten ()
    {
        return $this->kosten;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $bezeichnung
     */
    public function setBezeichnung ($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }

    /**
     * @param string $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param int $kosten
     */
    public function setKosten ($kosten)
    {
        $this->kosten = $kosten;
    }

    /**
     * @return Application_Model_Magie[]
     */
    public function getMagien ()
    {
        return $this->magien;
    }

    /**
     * @param Application_Model_Magie[] $magien
     */
    public function setMagien ($magien)
    {
        foreach ($magien as $magie) {
            $this->addMagie($magie);
        }
    }

    /**
     * @param Application_Model_Magie $magie
     */
    public function addMagie (Application_Model_Magie $magie)
    {
        $this->magien[] = $magie;
    }

}
