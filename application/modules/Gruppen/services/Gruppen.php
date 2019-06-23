<?php

/**
 * Description of Gruppen
 *
 * @author Voß
 */
class Gruppen_Service_Gruppen implements Application_Model_Events_Subject
{

    use Application_Model_Events_SubjectTrait;

    const NEW_MESSAGE_EVENT = 'NEW_GROUP_MESSAGE';
    const READ_MESSAGE_EVENT = 'READ_GROUP_MESSAGE';
    const JOINED_GROUP_EVENT = 'JOINED_GROUP';

    /**
     * @var array
     */
    private $events = [];

    /**
     * @param $charakterId
     *
     * @return array
     * @throws Exception
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
     * @throws Zend_Db_Select_Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Zend_Db_Select_Exception
     */
    public function validateAccess ($gruppenId, $charakterId, $userId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->validateAccess($gruppenId, $charakterId, $userId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return int
     * @throws Exception
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
        return $mapper->createGruppe($gruppe);
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $charakterId
     *
     * @throws Exception
     */
    public function switchDataExposure (Zend_Controller_Request_Http $request, $charakterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $mapper->setFreigabe($charakterId, $request->getPost('gruppenId'), $request->getPost('exposed'));
    }


    /**
     * @param $gruppenId
     * @param $charakterId
     *
     * @throws Exception
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
        $date = new DateTime();
        $nachricht = new Gruppen_Model_Nachricht();
        $nachricht->setCreateDate($date->format('Y-m-d H:i:s'));
        $nachricht->setNachricht($request->getPost('nachricht'));
        $nachricht->setUserId($userId);
        $messageId = $mapper->addNachricht($nachricht, $request->getPost('gruppenId'));
        $this->events[] = ['event' => self::NEW_MESSAGE_EVENT, 'messageId' => $messageId];

        return $messageId;
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
     * @throws Exception
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
     * @param $characterId
     *
     * @throws Exception
     */
    public function joinGruppe (Zend_Controller_Request_Http $request, $characterId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        $gruppe = $mapper->getGruppeByCredentials($request->getPost('gruppenname'), $request->getPost('passwort'));
        if ($gruppe !== false) {
            $mapper->addCharakterToGroup($characterId, $gruppe->getId());
            $this->events[] = ['event' => self::JOINED_GROUP_EVENT, 'characterId' => $characterId];
        }
    }

    /**
     * @param $gruppenId
     * @param $charakterId
     *
     * @return bool
     * @throws Exception
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
     * @throws Exception
     */
    public function getExposedIds ($gruppenId)
    {
        $mapper = new Gruppen_Model_Mapper_GruppenMapper();
        return $mapper->getFreigaben($gruppenId);
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $leaderId
     *
     * @throws Exception
     */
    public function addToGroup (Zend_Controller_Request_Http $request, $leaderId)
    {
        if ($this->isLeader($leaderId, $request->getPost('gruppenId'))) {
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $characterId) {
                $characterGroupId = $mapper->addCharakterToGroup($characterId, $request->getPost('gruppenId'));
                $this->events[] = ['event' => self::JOINED_GROUP_EVENT, 'characterGroupId' => $characterGroupId];
            }
        }
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $leaderId
     *
     * @throws Exception
     */
    public function removeFromGroup (Zend_Controller_Request_Http $request, $leaderId)
    {
        if ($this->isLeader($leaderId, $request->getPost('gruppenId'))) {
            $mapper = new Gruppen_Model_Mapper_GruppenMapper();
            foreach ($request->getPost('charaktere') as $characterId) {
                $mapper->removeCharakterFromGroup($characterId, $request->getPost('gruppenId'));
            }
        }
    }

    /**
     * @param $leaderId
     * @param $gruppenId
     *
     * @return bool
     * @throws Zend_Db_Select_Exception
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

}
