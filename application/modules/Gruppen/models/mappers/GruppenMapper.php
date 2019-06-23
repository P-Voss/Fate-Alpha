<?php

class Gruppen_Model_Mapper_GruppenMapper
{

    /**
     * @param string $tablename
     *
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    protected function getDbTable ($tablename)
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param int $charakterId
     *
     * @return array
     * @throws Exception
     */
    public function getGruppenByCharakterId ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->joinInner('charakterGruppen', 'spielergruppen.gruppenId = charakterGruppen.gruppenId');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        foreach ($result as $row) {
            $gruppe = new Gruppen_Model_Gruppe();
            $gruppe->setId($row->gruppenId);
            $gruppe->setName($row->name);
            $gruppe->setBeschreibung($row->beschreibung);
            $gruppe->setPasswort($row->passwort);
            $gruppe->setGruender($row->userId);
            $gruppe->setCreateDate($row->createDate);
            $returnArray[] = $gruppe;
        }
        return $returnArray;
    }

    /**
     * @param string $gruppenName
     * @param string $passwort
     *
     * @return boolean|\Gruppen_Model_Gruppe
     * @throws Exception
     */
    public function getGruppeByCredentials ($gruppenName, $passwort)
    {
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->where('name = ?', $gruppenName);
        $select->where('passwort = ?', $passwort);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if ($row !== null) {
            $gruppe = new Gruppen_Model_Gruppe();
            $gruppe->setId($row->gruppenId);
            $gruppe->setName($row->name);
            $gruppe->setBeschreibung($row->beschreibung);
            $gruppe->setPasswort($row->passwort);
            $gruppe->setGruender($row->userId);
            $gruppe->setCreateDate($row->createDate);
            return $gruppe;
        }
        return false;
    }

    /**
     * @param int $userId
     *
     * @return Gruppen_Model_Gruppe[]
     * @throws Zend_Db_Select_Exception
     */
    public function getGruppenByUserId ($userId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);

        $selectPlayer = $this->getDbTable('Spielergruppen')->select();
        $selectPlayer->setIntegrityCheck(false);
        $selectPlayer->from('spielergruppen');
        $selectPlayer->joinLeft('charakterGruppen', 'charakterGruppen.gruppenId = spielergruppen.gruppenId', []);
        $selectPlayer->joinLeft('charakter', 'charakter.charakterId = charakterGruppen.charakterId', []);
        $selectPlayer->where('charakter.userId = ?', $userId);

        $selectLeader = $this->getDbTable('Spielergruppen')->select();
        $selectLeader->where('userId = ?', $userId);
        $select->union([$selectPlayer, $selectLeader]);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        foreach ($result as $row) {
            $gruppe = new Gruppen_Model_Gruppe();
            $gruppe->setId($row->gruppenId);
            $gruppe->setName($row->name);
            $gruppe->setBeschreibung($row->beschreibung);
            $gruppe->setPasswort($row->passwort);
            $gruppe->setGruender($row->userId);
            $gruppe->setCreateDate($row->createDate);
            $returnArray[] = $gruppe;
        }
        return $returnArray;
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws Exception
     */
    public function getGruppenByLeaderId ($userId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->orWhere('spielergruppen.userId = ?', $userId);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        foreach ($result as $row) {
            $gruppe = new Gruppen_Model_Gruppe();
            $gruppe->setId($row->gruppenId);
            $gruppe->setName($row->name);
            $gruppe->setBeschreibung($row->beschreibung);
            $gruppe->setPasswort($row->passwort);
            $gruppe->setGruender($row->userId);
            $gruppe->setCreateDate($row->createDate);
            $returnArray[] = $gruppe;
        }
        return $returnArray;
    }

    /**
     * @param int $gruppenId
     *
     * @return Gruppen_Model_Gruppe
     * @throws Exception
     */
    public function getGruppeByGruppenId ($gruppenId)
    {
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->where('gruppenId = ?', $gruppenId);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if ($row === null) {
            throw new Exception('Group does not exist');
        }
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setId($row->gruppenId);
        $gruppe->setName($row->name);
        $gruppe->setBeschreibung($row->beschreibung);
        $gruppe->setPasswort($row->passwort);
        $gruppe->setGruender($row->userId);
        $gruppe->setCreateDate($row->createDate);
        return $gruppe;
    }

    /**
     * @param int $messageId
     *
     * @return Gruppen_Model_Gruppe
     * @throws Exception
     */
    public function getGroupByMessageId (int $messageId)
    {
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false)
            ->from('spielergruppen')
            ->joinInner('gruppenchat', 'gruppenchat.gruppenId = spielergruppen.gruppenId', [])
            ->where('gruppenchat.nachrichtenId = ?', $messageId);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if ($row === null) {
            throw new Exception('Group does not exist');
        }
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setId($row->gruppenId);
        $gruppe->setName($row->name);
        $gruppe->setBeschreibung($row->beschreibung);
        $gruppe->setPasswort($row->passwort);
        $gruppe->setGruender($row->userId);
        $gruppe->setCreateDate($row->createDate);
        return $gruppe;
    }

    /**
     * @param int $zuoId
     *
     * @return Gruppen_Model_Gruppe
     * @throws Exception
     */
    public function getGroupByCharacterZuo (int $zuoId)
    {
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false)
            ->from('spielergruppen')
            ->joinInner('charakterGruppen', 'charakterGruppen.gruppenId = spielergruppen.gruppenId', [])
            ->where('charakterGruppen.zuoId = ?', $zuoId);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if ($row === null) {
            throw new Exception('Group does not exist');
        }
        $gruppe = new Gruppen_Model_Gruppe();
        $gruppe->setId($row->gruppenId);
        $gruppe->setName($row->name);
        $gruppe->setBeschreibung($row->beschreibung);
        $gruppe->setPasswort($row->passwort);
        $gruppe->setGruender($row->userId);
        $gruppe->setCreateDate($row->createDate);
        return $gruppe;
    }

    /**
     * @param $id
     *
     * @return Gruppen_Model_CharacterToGroup
     * @throws Exception
     */
    public function getCharacterToGroup ($id)
    {
        $select = $this->getDbTable('Spielergruppen')
            ->select()
            ->setIntegrityCheck(false)
            ->from('charakterGruppen')
            ->where('charakterGruppen.zuoId = ?', $id);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if ($row === null) {
            throw new Exception('Group does not exist');
        }
        return new Gruppen_Model_CharacterToGroup($row->charakterId, $row->gruppenId);
    }

    /**
     * @param int $gruppenId
     *
     * @return Application_Model_Charakter[]
     * @throws Exception
     */
    public function getGruppenmitglieder ($gruppenId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterGruppen', []);
        $select->joinInner('charakter', 'charakter.charakterId = charakterGruppen.charakterId');
        $select->where('charakterGruppen.gruppenId = ?', $gruppenId);
        $result = $this->getDbTable('CharakterGruppen')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Application_Model_Charakter();
            $model->setUserid($row->userId);
            $model->setVorname($row->vorname);
            $model->setNachname($row->nachname);
            $model->setCharakterid($row->charakterId);
            $model->setAugenfarbe($row->augenfarbe);
            $model->setGeburtsdatum($row->geburtsdatum);
            $model->setGeschlecht($row->geschlecht);
            $model->setSexualitaet($row->sexualitaet);
            $model->setMagiccircuit($row->circuit);
            $model->setNickname($row->nickname);
            $model->setSize($row->size);
            $model->setWohnort($row->wohnort);
            $date = new DateTime($row->createDate);
            $model->setCreatedate($date);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @param int $gruppenId
     * @param int $charakterId
     * @param int $userId
     *
     * @return boolean
     * @throws Zend_Db_Select_Exception
     */
    public function validateAccess ($gruppenId, $charakterId, $userId)
    {
        $selectOwner = $this->getDbTable('Spielergruppen')->select();
        $selectOwner->from('spielergruppen', ['gruppenId']);
        $selectOwner->where('userId = ?', $userId);
        $selectOwner->where('gruppenId = ?', $gruppenId);
        $selectCharakter = $this->getDbTable('CharakterGruppen')->select();
        $selectCharakter->from('charakterGruppen', ['gruppenId']);
        $selectCharakter->where('charakterId = ?', $charakterId);
        $selectCharakter->where('gruppenId = ?', $gruppenId);
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->union([$selectOwner, $selectCharakter]);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param Gruppen_Model_Gruppe $gruppe
     *
     * @return int
     * @throws Exception
     */
    public function createGruppe (Gruppen_Model_Gruppe $gruppe)
    {
        $data = [
            'name' => $gruppe->getName(),
            'beschreibung' => $gruppe->getBeschreibung(),
            'passwort' => $gruppe->getPasswort(),
            'createDate' => $gruppe->getCreateDate(),
            'userId' => $gruppe->getGruender(),
        ];
        return $this->getDbTable('Spielergruppen')->insert($data);
    }

    /**
     * @param Gruppen_Model_Gruppe $gruppe
     *
     * @return int
     * @throws Exception
     */
    public function editGruppe (Gruppen_Model_Gruppe $gruppe)
    {
        $data = [
            'name' => $gruppe->getName(),
            'beschreibung' => $gruppe->getBeschreibung(),
            'passwort' => $gruppe->getPasswort(),
        ];
        return $this->getDbTable('Spielergruppen')->update($data, ['gruppenId = ?' => $gruppe->getId()]);
    }

    /**
     * @param int $charakterId
     * @param int $gruppenId
     * @param string $exposure
     *
     * @throws Exception
     */
    public function setFreigabe ($charakterId, $gruppenId, $exposure)
    {
        $data = [
            'freigabe' => ($exposure == 0),
        ];
        $this->getDbTable('CharakterGruppen')->update(
            $data, [
                     'charakterId = ?' => $charakterId,
                     'gruppenId = ?' => $gruppenId,
                 ]
        );
    }

    /**
     * @param int $gruppenId
     * @param int $charakterId
     *
     * @return boolean
     * @throws Exception
     */
    public function checkFreigabe ($gruppenId, $charakterId)
    {
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('gruppenId = ?', $gruppenId);
        $row = $this->getDbTable('CharakterGruppen')->fetchRow($select);
        if ($row !== null) {
            return $row->freigabe;
        }
        return false;
    }

    /**
     * @param int $gruppenId
     *
     * @return array
     * @throws Exception
     */
    public function getFreigaben ($gruppenId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->where('gruppenId = ? AND freigabe = 1', $gruppenId);
        $result = $this->getDbTable('CharakterGruppen')->fetchAll($select);
        foreach ($result as $row) {
            $returnArray[] = $row->charakterId;
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     * @param int $gruppenId
     *
     * @return mixed
     * @throws Exception
     */
    public function addCharakterToGroup ($charakterId, $gruppenId)
    {
        $data = [
            'charakterId' => $charakterId,
            'gruppenId' => $gruppenId,
            'freigabe' => 0,
        ];
        return $this->getDbTable('CharakterGruppen')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $gruppenId
     *
     * @return int
     * @throws Exception
     */
    public function removeCharakterFromGroup ($charakterId, $gruppenId)
    {
        return $this->getDbTable('CharakterGruppen')->delete(
            [
                'charakterId = ?' => $charakterId,
                'gruppenId = ?' => $gruppenId,
            ]
        );
    }

    /**
     * @param Gruppen_Model_Nachricht $nachricht
     * @param int $gruppenId
     *
     * @return int
     * @throws Exception
     */
    public function addNachricht (Gruppen_Model_Nachricht $nachricht, $gruppenId)
    {
        $data = [
            'gruppenId' => $gruppenId,
            'userId' => $nachricht->getUserId(),
            'nachricht' => $nachricht->getNachricht(),
            'createDate' => $nachricht->getCreateDate('Y-m-d H:i:s'),
        ];
        return $this->getDbTable('Gruppenchat')->insert($data);
    }

    /**
     * @param int $gruppenId
     *
     * @return Gruppen_Model_Nachricht[]
     * @throws Exception
     */
    public function getNachrichtenByGruppenId ($gruppenId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Gruppenchat')->select();
        $select->where('gruppenId = ? AND TIMESTAMPDIFF(MONTH, createDate, NOW()) < 4', $gruppenId);
        $select->order('nachrichtenId DESC');
        $result = $this->getDbTable('Gruppenchat')->fetchAll($select);
        foreach ($result as $row) {
            $nachricht = new Gruppen_Model_Nachricht();
            $nachricht->setId($row->nachrichtenId);
            $nachricht->setNachricht($row->nachricht);
            $nachricht->setCreateDate($row->createDate);
            $nachricht->setUserId($row->userId);
            $returnArray[] = $nachricht;
        }
        return $returnArray;
    }

    /**
     * @param int $messageId
     *
     * @return Gruppen_Model_Nachricht
     * @throws Exception
     */
    public function getMessage (int $messageId): Gruppen_Model_Nachricht
    {
        $row = $this->getDbTable('Gruppenchat')->fetchRow(['nachrichtenId = ?' => $messageId]);
        if ($row === null) {
            throw new Exception('Message does not exist');
        }
        $message = new Gruppen_Model_Nachricht();
        $message->setId($row->nachrichtenId);
        $message->setNachricht($row->nachricht);
        $message->setCreateDate($row->createDate);
        $message->setUserId($row->userId);

        return $message;
    }

}
