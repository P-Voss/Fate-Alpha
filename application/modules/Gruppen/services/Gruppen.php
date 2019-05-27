<?php

/**
 * Description of Gruppen
 *
 * @author Voß
 */
class Gruppen_Service_Gruppen
{


    /**
     * @param $charakterId
     *
     * @return array
     */
    public function getGruppenByCharakterId ($charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByCharakterId($charakterId);
    }


    /**
     * @param $userId
     *
     * @return array
     */
    public function getGruppenByUserId ($userId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByUserId($userId);
    }


    /**
     * @param $userId
     *
     * @return array
     */
    public function getGruppenByLeaderId ($userId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getGruppenByLeaderId($userId);
    }


    /**
     * @param $gruppenId
     *
     * @return Gruppen_Model_Gruppe
     */
    public function getGruppeByGruppenId ($gruppenId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = $mapper->getGruppeByGruppenId($gruppenId);
        if ($gruppe !== false) {
            $gruppe->setMitglieder($mapper->getGruppenmitglieder($gruppe->getId()));
        }
        return $gruppe;
    }


    /**
     * @param $gruppenId
     * @param $charakterId
     * @param $userId
     *
     * @return bool
     */
    public function validateAccess ($gruppenId, $charakterId, $userId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->validateAccess($gruppenId, $charakterId, $userId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return bool
     */
    public function createGruppe (Zend_Controller_Request_Http $request)
    {
        if ($request->getPost('gruppenname') == '') {
            return false;
        }
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $date = new DateTime();
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setGruender(Zend_Auth::getInstance()->getIdentity()->userId);
        $gruppe->setBeschreibung($request->getPost('beschreibung'));
        $gruppe->setName($request->getPost('gruppenname'));
        $gruppe->setPasswort($request->getPost('passwort'));
        $gruppe->setCreateDate($date->format('Y-m-d'));
        $mapper->createGruppe($gruppe);
        return true;
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $charakterId
     */
    public function switchDataExposure (Zend_Controller_Request_Http $request, $charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $mapper->setFreigabe($charakterId, $request->getPost('gruppenId'), $request->getPost('exposed'));
    }


    /**
     * @param $gruppenId
     * @param $charakterId
     */
    public function leaveGroup ($gruppenId, $charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $mapper->removeCharakterFromGroup($charakterId, $gruppenId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $userId
     *
     * @return int
     * @throws Exception
     */
    public function addNachricht (Zend_Controller_Request_Http $request, $userId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $userMapper = new Application_Model_Mapper_UserMapper();
        $date = new DateTime();
        $nachricht = new Gruppen_Model_Nachricht();
        $nachricht->setCreateDate($date->format('Y-m-d H:i:s'));
        $nachricht->setNachricht($request->getPost('nachricht'));
        $nachricht->setUserId($userId);
        $nachrichtenId = $mapper->addNachricht($nachricht, $request->getPost('gruppenId'));
        $userMapper->addNotificationForGroup($nachrichtenId);
        $userMapper->addGroupleaderNotification($nachrichtenId);
        return $nachrichtenId;
    }

    /**
     * @param $gruppenId
     *
     * @return array
     * @throws Exception
     */
    public function getGruppenchat ($gruppenId)
    {
        $userService = new Application_Service_User();
        $charakterService = new Application_Service_Charakter();
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $nachrichten = $mapper->getNachrichtenByGruppenId($gruppenId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setUser($userService->getUserById($nachricht->getUserId()));
            try {
                $charakter = $charakterService->getCharakterByUserid($nachricht->getUserId());
                $nachricht->setCharakter($charakter);
            } catch (Exception $exception) {}
        }
        return $nachrichten;
    }


    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return bool
     */
    public function editGruppe (Zend_Controller_Request_Http $request)
    {
        if ($request->getPost('gruppenname') == '') {
            return false;
        }
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setId($request->getPost('gruppenId'));
        $gruppe->setBeschreibung($request->getPost('beschreibung', ''));
        $gruppe->setName($request->getPost('gruppenname'));
        $gruppe->setPasswort($request->getPost('passwort'));
        $mapper->editGruppe($gruppe);
        return true;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $charakterId
     */
    public function joinGruppe (Zend_Controller_Request_Http $request, $charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = $mapper->getGruppeByCredentials($request->getPost('gruppenname'), $request->getPost('passwort'));
        if ($gruppe !== false) {
            $mapper->addCharakterToGroup($charakterId, $gruppe->getId());
        }
    }

    /**
     *
     */
    public function setSl ()
    {

    }

    /**
     * @param $gruppenId
     * @param $charakterId
     *
     * @return bool
     */
    public function dataExposed ($gruppenId, $charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->checkFreigabe($gruppenId, $charakterId);
    }


    /**
     * @param $gruppenId
     *
     * @return array
     */
    public function getExposedIds ($gruppenId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getFreigaben($gruppenId);
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $leaderId
     */
    public function addToGroup (Zend_Controller_Request_Http $request, $leaderId)
    {
        if ($this->isLeader($leaderId, $request->getPost('gruppenId'))) {
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $charakterId) {
                $mapper->addCharakterToGroup($charakterId, $request->getPost('gruppenId'));
            }
        }
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $leaderId
     */
    public function removeFromGroup (Zend_Controller_Request_Http $request, $leaderId)
    {
        if ($this->isLeader($leaderId, $request->getPost('gruppenId'))) {
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $charakterId) {
                $mapper->removeCharakterFromGroup($charakterId, $request->getPost('gruppenId'));
            }
        }
    }

    /**
     * @param $leaderId
     * @param $gruppenId
     *
     * @return bool
     */
    public function isLeader ($leaderId, $gruppenId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppen = $mapper->getGruppenByUserId($leaderId);
        foreach ($gruppen as $gruppe) {
            if ($gruppe->getId() == $gruppenId) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param $gruppenId
     *
     * @return array
     * @throws Exception
     */
    public function getLogsByGruppenId ($gruppenId)
    {
        $mapper = new Gruppen_Model_Mapper_LogMapper();
        return $mapper->getLogsByGruppe($gruppenId);
    }


    /**
     * @param $userId
     * @param $gruppenId
     *
     * @throws Exception
     */
    public function removeNotifications ($userId, $gruppenId)
    {
        $mapper = new Application_Model_Mapper_UserMapper();
        $mapper->removeUserNotificationsForGroup($userId, $gruppenId);
    }

}
