<?php

/**
 * Description of Application_Model_Episode
 *
 * @author Voß
 */
class Application_Model_Episode {
    
    protected $id;
    protected $plotId;
    protected $name;
    protected $beschreibung;
    protected $zusammenfassung;
    /**
     * @var Application_Model_Interfaces_EpisodenStatus
     */
    protected $status;
    
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getZusammenfassung() {
        return $this->zusammenfassung;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setZusammenfassung($zusammenfassung) {
        $this->zusammenfassung = $zusammenfassung;
    }
    
    public function getPlotId() {
        return $this->plotId;
    }
    
    public function setPlotId($plotId) {
        $this->plotId = $plotId;
    }
    
    /**
     * @return Application_Model_EpisodenStatus
     */
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus(Application_Model_Interfaces_EpisodenStatus $status) {
        $this->status = $status;
    }
    
}
