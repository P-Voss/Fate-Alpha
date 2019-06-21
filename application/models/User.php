<?php

/**
 * Description of User
 *
 * @author Vosser
 */
class Application_Model_User {

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $accessKey;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $profilname;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $passwort;
    /**
     * @var string
     */
    protected $usergruppe;
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;

    /**
     * @var bool
     */
    protected $isLogleser = false;


    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getProfilname() {
        return $this->profilname;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsergruppe() {
        return $this->usergruppe;
    }

    /**
     * @return string
     */
    public function getPasswort() {
        return $this->passwort;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @param $profilname
     */
    public function setProfilname($profilname) {
        $this->profilname = $profilname;
    }

    /**
     * @param $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param $usergruppe
     */
    public function setUsergruppe($usergruppe) {
        $this->usergruppe = $usergruppe;
    }

    /**
     * @param $passwort
     */
    public function setPasswort($passwort) {
        $this->passwort = $passwort;
    }

    /**
     * @return Application_Model_Charakter
     */
    public function getCharakter() {
        return $this->charakter;
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    /**
     * @return bool
     */
    public function getIsLogleser() {
        return $this->isLogleser;
    }

    /**
     * @param $isLogleser
     */
    public function setIsLogleser($isLogleser) {
        $this->isLogleser = $isLogleser;
    }

    /**
     * @return string
     */
    public function getAccessKey ()
    {
        return $this->accessKey;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey ($accessKey)
    {
        $this->accessKey = $accessKey;
    }
    
}
