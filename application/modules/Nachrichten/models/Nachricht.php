<?php

/**
 * Description of Nachricht
 *
 * @author Voß
 */
class Nachrichten_Model_Nachricht {
    
    protected $id;
    protected $betreff;
    protected $nachricht;
    protected $verfasserId;
    protected $empfaengerId;
    protected $creationDate;
    protected $status;
    /**
     * @var Application_Model_User
     */
    protected $verfasser;
    /**
     * @var Application_Model_User
     */
    protected $empfaenger;


    public function getId() {
        return $this->id;
    }

    public function getBetreff() {
        return $this->betreff;
    }

    public function getNachricht() {
        return $this->nachricht;
    }

    public function getVerfasserId() {
        return $this->verfasserId;
    }

    public function getEmpfaengerId() {
        return $this->empfaengerId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBetreff($betreff) {
        $this->betreff = $betreff;
    }

    public function setNachricht($nachricht) {
        $this->nachricht = $nachricht;
    }

    public function setVerfasserId($verfasserId) {
        $this->verfasserId = $verfasserId;
    }

    public function setEmpfaengerId($empfaengerId) {
        $this->empfaengerId = $empfaengerId;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getVerfasser() {
        return $this->verfasser;
    }

    public function getEmpfaenger() {
        return $this->empfaenger;
    }

    public function setVerfasser(Application_Model_User $verfasser) {
        $this->verfasser = $verfasser;
    }

    public function setEmpfaenger(Application_Model_User $empfaenger) {
        $this->empfaenger = $empfaenger;
    }

}
