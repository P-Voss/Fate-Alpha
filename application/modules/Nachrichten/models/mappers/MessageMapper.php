<?php

namespace Nachrichten\Models\Mappers;

use Nachrichten\Models\Message;
use Nachrichten\Models\User;

/**
 * Description of MessageMapper
 *
 * @author Voß
 */
class MessageMapper
{

    /**
     * @param string $tablename
     *
     * @return \Zend_Db_Table_Abstract
     * @throws \Exception
     */
    public function getDbTable ($tablename)
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new \Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof \Zend_Db_Table_Abstract) {
            throw new \Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param int $userId
     *
     * @return Message[]
     * @throws \Exception
     */
    public function getNachrichtenByReceiverId ($userId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Pm')->select();
        $select->where('empfaengerId = ?', $userId);
        $select->where('status != ?', 'archiv');
        $select->order('creationDate DESC');
        $result = $this->getDbTable('Pm')->fetchAll($select);
        foreach ($result as $row) {
            $nachricht = new Message();
            $nachricht->setId($row->nachrichtId);
            $nachricht->setVerfasserId($row->verfasserId);
            $nachricht->setEmpfaengerId($row->empfaengerId);
            $nachricht->setBetreff($row->betreff);
            $nachricht->setNachricht($row->nachricht);
            $nachricht->setCreationDate($row->creationDate);
            $nachricht->setStatus($row->status);
            $nachricht->setAdmin($row->admin === 1);
            $returnArray[] = $nachricht;
        }
        return $returnArray;
    }

    /**
     * @param int $userId
     *
     * @return Message[]
     * @throws \Exception
     */
    public function getNachrichtenByDispatcherId ($userId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Pm')->select();
        $select->where('verfasserId = ?', $userId);
        $select->order('creationDate DESC');
        $result = $this->getDbTable('Pm')->fetchAll($select);
        foreach ($result as $row) {
            $nachricht = new Message();
            $nachricht->setId($row->nachrichtId);
            $nachricht->setVerfasserId($row->verfasserId);
            $nachricht->setEmpfaengerId($row->empfaengerId);
            $nachricht->setBetreff($row->betreff);
            $nachricht->setNachricht($row->nachricht);
            $nachricht->setCreationDate($row->creationDate);
            $nachricht->setStatus($row->status);
            $nachricht->setAdmin($row->admin === 1);
            $returnArray[] = $nachricht;
        }
        return $returnArray;
    }

    /**
     * @param int $userId
     *
     * @return Message[]
     * @throws \Exception
     */
    public function getNachrichtenarchivById ($userId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Pm')->select();
        $select->where('empfaengerId = ?', $userId);
        $select->where('status = ?', 'archiv');
        $select->order('creationDate DESC');
        $result = $this->getDbTable('Pm')->fetchAll($select);
        foreach ($result as $row) {
            $nachricht = new Message();
            $nachricht->setId($row->nachrichtId);
            $nachricht->setVerfasserId($row->verfasserId);
            $nachricht->setEmpfaengerId($row->empfaengerId);
            $nachricht->setBetreff($row->betreff);
            $nachricht->setNachricht($row->nachricht);
            $nachricht->setCreationDate($row->creationDate);
            $nachricht->setStatus($row->status);
            $nachricht->setAdmin($row->admin === 1);
            $returnArray[] = $nachricht;
        }
        return $returnArray;
    }

    /**
     * @param int $nachrichtId
     *
     * @return Message
     * @throws \Exception
     */
    public function getNachrichtById ($nachrichtId)
    {
        $nachricht = new Message();
        $select = $this->getDbTable('Pm')->select();
        $select->where('nachrichtId = ?', $nachrichtId);
        $result = $this->getDbTable('Pm')->fetchRow($select);
        if ($result !== null) {
            $nachricht->setId($result->nachrichtId);
            $nachricht->setVerfasserId($result->verfasserId);
            $nachricht->setEmpfaengerId($result->empfaengerId);
            $nachricht->setBetreff($result->betreff);
            $nachricht->setNachricht($result->nachricht);
            $nachricht->setCreationDate($result->creationDate);
            $nachricht->setStatus($result->status);
            $nachricht->setAdmin($result->admin === 1);
        }
        return $nachricht;
    }

    /**
     * @param int $userId
     *
     * @return User
     * @throws \Exception
     */
    public function getUserForPmById ($userId)
    {
        $user = new User();
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('benutzerdaten', ['profilname', 'username', 'mail', 'usergruppe']);
        $select->joinLeft(
            'charakter', 'charakter.userId = benutzerdaten.userId AND charakter.active = 1', [
            'vorname', 'nachname', 'charakterId']
        );
        $select->where('benutzerdaten.userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchRow($select);
        if ($result !== false) {
            $user->setId($userId);
            $user->setProfilname($result['profilname']);
            $user->setUsername($result['username']);
            $user->setEmail($result['mail']);
            $user->setUsergruppe($result['usergruppe']);
            if ($result['charakterId'] !== null) {
                $user->setCharakterName($result['vorname'] . ' ' . $result['nachname']);
            }
        }
        return $user;
    }

    /**
     * @param Message $nachricht
     *
     * @return int
     * @throws \Exception
     */
    public function saveMessage (Message $nachricht)
    {
        $date = new \DateTime();
        $data = [
            'verfasserId' => $nachricht->getVerfasserId(),
            'empfaengerId' => $nachricht->getEmpfaengerId(),
            'betreff' => $nachricht->getBetreff(),
            'nachricht' => $nachricht->getNachricht(),
            'creationDate' => $date->format('Y-m-d H:i:s'),
            'admin' => ($nachricht->getAdmin() === true) ? 1 : 0,
        ];
        return $this->getDbTable('Pm')->insert($data);
    }

    /**
     * @param int $nachrichtId
     *
     * @throws \Exception
     */
    public function setRead ($nachrichtId)
    {
        $data = ['status' => 'gelesen'];
        $this->getDbTable('Pm')->update($data, ['nachrichtId = ?' => $nachrichtId]);
    }

    /**
     * @param Message $nachricht
     *
     * @return int
     * @throws \Exception
     */
    public function deleteMessage (Message $nachricht)
    {
        $data = ['status' => 'archiv'];
        return $this->getDbTable('Pm')->update($data, ['nachrichtId = ?' => $nachricht->getId()]);
    }

}
