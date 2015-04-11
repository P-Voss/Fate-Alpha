<?php

/**
 * Description of Layout
 *
 * @author Vosser
 */
class Application_Model_Layout {
    
    /**
     * @var boolean
     */
    public $hasChara;
    /**
     * @var Application_Model_Charakter
     */
    public $charakter;
    public $charakterTraining;
    public $unreadPmCount;
    public $usergruppe;


    public function getHasChara() {
        return $this->hasChara;
    }

    public function getCharakter() {
        return $this->charakter;
    }

    public function getCharakterTraining() {
        return $this->charakterTraining;
    }

    public function getUnreadPmCount() {
        return $this->unreadPmCount;
    }

    public function setHasChara($hasChara) {
        $this->hasChara = $hasChara;
    }

    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    public function setCharakterTraining($charakterTraining) {
        $this->charakterTraining = $charakterTraining;
    }

    public function setUnreadPmCount($unreadPmCount) {
        $this->unreadPmCount = $unreadPmCount;
    }

    public function getUsergruppe() {
        return $this->usergruppe;
    }

    public function setUsergruppe($usergruppe) {
        $this->usergruppe = $usergruppe;
    }


    
}
