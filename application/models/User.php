<?php

/**
 * Description of User
 *
 * @author Vosser
 */
class Application_Model_User {
    
    protected $id;
    protected $username;
    protected $profilname;
    protected $email;
    protected $passwort;
    protected $usergruppe;
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;
    
    protected $isLogleser = false;


    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getProfilname() {
        return $this->profilname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsergruppe() {
        return $this->usergruppe;
    }
    
    public function getPasswort() {
        return $this->passwort;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setProfilname($profilname) {
        $this->profilname = $profilname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setUsergruppe($usergruppe) {
        $this->usergruppe = $usergruppe;
    }
    
    public function setPasswort($passwort) {
        $this->passwort = $passwort;
    }
    
    public function getCharakter() {
        return $this->charakter;
    }

    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }
    
    public function getIsLogleser() {
        return $this->isLogleser;
    }

    public function setIsLogleser($isLogleser) {
        $this->isLogleser = $isLogleser;
    }
    
}
