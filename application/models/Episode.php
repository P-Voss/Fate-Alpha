<?php

/**
 * Description of Application_Model_Episode
 *
 * @author Voß
 */
class Application_Model_Episode
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $plotId;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $zusammenfassung;
    /**
     * @var Application_Model_Interfaces_EpisodenStatus
     */
    protected $status;


    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
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
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return string
     */
    public function getZusammenfassung ()
    {
        return $this->zusammenfassung;
    }

    /**
     * @param $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $zusammenfassung
     */
    public function setZusammenfassung ($zusammenfassung)
    {
        $this->zusammenfassung = $zusammenfassung;
    }

    /**
     * @return int
     */
    public function getPlotId ()
    {
        return $this->plotId;
    }

    /**
     * @param $plotId
     */
    public function setPlotId ($plotId)
    {
        $this->plotId = $plotId;
    }

    /**
     * @return Application_Model_Interfaces_EpisodenStatus
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param Application_Model_Interfaces_EpisodenStatus $status
     */
    public function setStatus (Application_Model_Interfaces_EpisodenStatus $status)
    {
        $this->status = $status;
    }

}
