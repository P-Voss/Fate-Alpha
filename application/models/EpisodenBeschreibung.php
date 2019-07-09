<?php

/**
 * Description of Application_Model_EpisodenBeschreibung
 *
 * @author Voß
 */
class Application_Model_EpisodenBeschreibung
{

    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $creationdate;

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
    public function getCreationdate ()
    {
        return $this->creationdate;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $creationdate
     */
    public function setCreationdate ($creationdate)
    {
        $this->creationdate = $creationdate;
    }

}
