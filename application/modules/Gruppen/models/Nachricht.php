<?php

/**
 * Description of Nachricht
 *
 * @author Voß
 */
class Gruppen_Model_Nachricht {
    
    protected $id;
    protected $nachricht;
    protected $charakter;
    protected $user;
    protected $userId;
    /**
     * @var DateTime
     */
    protected $createDate;
    
    public function getId() {
        return $this->id;
    }

    public function getNachricht() {
        return $this->nachricht;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getCreateDate($format = 'd.m.Y H:i:s') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNachricht($nachricht) {
        $this->nachricht = $nachricht;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }
    
    /**
     * @return Application_Model_Charakter
     */
    public function getCharakter() {
        return $this->charakter;
    }

    /**
     * @return Application_Model_User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    /**
     * @param Application_Model_User $user
     */
    public function setUser(Application_Model_User $user) {
        $this->user = $user;
    }


    
}
