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
    /**
     * @var Application_Model_Training_Program
     */
    public $charakterTraining;
    public $unreadPmCount;
    public $usergruppe;
    public $logleser;
    public $informations = array();
    public $notifications = array();


    public function getHasChara() {
        return $this->hasChara;
    }

    public function getCharakter() {
        return $this->charakter;
    }

    /**
     * @return Application_Model_Training_Program
     */
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

    /**
     * @param Application_Model_Training_Program $charakterTraining
     */
    public function setCharakterTraining(Application_Model_Training_Program $charakterTraining) {
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
    
    public function setInformations($informations = array()) {
        foreach ($informations as $information) {
            if($information instanceof Application_Model_Information){
                $this->informations[] = $information;
            }
        }
    }
    
    public function addInformation(Application_Model_Information $information) {
        $this->informations[] = $information;
    }
    
    public function getInformations() {
        return $this->informations;
    }
    
    public function deleteInformations() {
        $this->informations = array();
    }
    
    public function getLogleser() {
        return $this->logleser === true;
    }
    
    public function setLogleser($logleser) {
        $this->logleser = $logleser;
    }
    
    public function getNotifications() {
        return $this->notifications;
    }

    public function setNotifications($notifications) {
        foreach ($notifications as $notification) {
            if ($notification instanceof Application_Model_Notification) {
                $this->notifications[] = $notification;
            }
        }
    }

    public function addNotification(Application_Model_Notification $notification) {
        $this->notifications[] = $notification;
    }
    
}
