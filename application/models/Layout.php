<?php

use Notification\Models\Notification;

/**
 * Description of Layout
 *
 * @author Vosser
 */
class Application_Model_Layout
{

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
    public $informations = [];
    /**
     * @var Notification[]
     */
    public $notifications = [];
    /**
     * @var Application_Model_Tageswetter
     */
    private $weather;


    /**
     * @return bool
     */
    public function getHasChara ()
    {
        return $this->hasChara;
    }

    /**
     * @return Application_Model_Charakter
     */
    public function getCharakter ()
    {
        return $this->charakter;
    }

    /**
     * @return Application_Model_Training_Program
     */
    public function getCharakterTraining ()
    {
        return $this->charakterTraining;
    }

    /**
     * @return mixed
     */
    public function getUnreadPmCount ()
    {
        return $this->unreadPmCount;
    }

    /**
     * @param $hasChara
     */
    public function setHasChara ($hasChara)
    {
        $this->hasChara = $hasChara;
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter (Application_Model_Charakter $charakter)
    {
        $this->charakter = $charakter;
    }

    /**
     * @param Application_Model_Training_Program $charakterTraining
     */
    public function setCharakterTraining (Application_Model_Training_Program $charakterTraining)
    {
        $this->charakterTraining = $charakterTraining;
    }

    /**
     * @param $unreadPmCount
     */
    public function setUnreadPmCount ($unreadPmCount)
    {
        $this->unreadPmCount = $unreadPmCount;
    }

    /**
     * @return mixed
     */
    public function getUsergruppe ()
    {
        return $this->usergruppe;
    }

    /**
     * @param $usergruppe
     */
    public function setUsergruppe ($usergruppe)
    {
        $this->usergruppe = $usergruppe;
    }

    /**
     * @param array $informations
     */
    public function setInformations ($informations = [])
    {
        foreach ($informations as $information) {
            $this->addInformation($information);
        }
    }

    /**
     * @param Application_Model_Information $information
     */
    public function addInformation (Application_Model_Information $information)
    {
        $this->informations[] = $information;
    }

    /**
     * @return array
     */
    public function getInformations ()
    {
        return $this->informations;
    }

    /**
     *
     */
    public function deleteInformations ()
    {
        $this->informations = [];
    }

    /**
     * @return bool
     */
    public function getLogleser ()
    {
        return $this->logleser === true;
    }

    /**
     * @param $logleser
     */
    public function setLogleser ($logleser)
    {
        $this->logleser = $logleser;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications ()
    {
        return $this->notifications;
    }

    /**
     * @param $notifications Notification[]
     */
    public function setNotifications ($notifications = [])
    {
        foreach ($notifications as $notification) {
            $this->addNotification($notification);
        }
    }

    /**
     * @param Notification $notification
     */
    public function addNotification (Notification $notification)
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return Application_Model_Tageswetter
     */
    public function getWeather (): Application_Model_Tageswetter
    {
        return $this->weather;
    }

    /**
     * @param Application_Model_Tageswetter $weather
     *
     * @return Application_Model_Layout
     */
    public function setWeather (Application_Model_Tageswetter $weather): Application_Model_Layout
    {
        $this->weather = $weather;
        return $this;
    }

}
