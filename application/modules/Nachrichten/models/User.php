<?php

/**
 * Description of Nachricht
 *
 * @author Voß
 */
class Nachrichten_Model_User extends Application_Model_User {
    
    private $charakterName;
    
    public function getCharakterName() {
        return $this->charakterName;
    }

    public function setCharakterName($charakterName) {
        $this->charakterName = $charakterName;
    }
    
    public function getProfilname() {
        if ($this->charakterName === '' || $this->charakterName === null) {
            return $this->profilname;
        } else {
            return $this->charakterName;
        }
    }
    
}
