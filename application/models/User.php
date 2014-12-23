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
    protected $usergruppe;
    
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


    
}
