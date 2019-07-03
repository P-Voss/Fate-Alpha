<?php

namespace Nachrichten\Models;

/**
 * Description of Nachricht
 *
 * @author Voß
 */
class User extends \Application_Model_User {

    /**
     * @var string
     */
    private $charakterName;

    /**
     * @return string
     */
    public function getCharakterName() {
        return $this->charakterName;
    }

    /**
     * @param $charakterName
     */
    public function setCharakterName($charakterName) {
        $this->charakterName = $charakterName;
    }

    /**
     * @return string
     */
    public function getProfilname() {
        if ($this->charakterName === '' || $this->charakterName === null) {
            return $this->profilname;
        } else {
            return $this->charakterName;
        }
    }
    
}
