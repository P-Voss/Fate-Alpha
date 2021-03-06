<?php

/**
 * Class Application_Model_Mapper_UserMapper
 */
class Application_Model_Mapper_UserMapper
{

    const NOTIFICATION_TYPE_GROUPMESSAGE = 1;
    const NOTIFICATION_TYPE_FEEDBACK_WISH = 2;


    /**
     * @param $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename)
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
     * @param $userId
     * @param $accessKey
     *
     * @throws Exception
     */
    public function updateAccessKey ($userId, $accessKey)
    {
        $this->getDbTable('User')->update(['accessKey' => $accessKey], ['userId = ?' => $userId]);
    }

    /**
     * @param int $userId
     *
     * @return boolean
     * @throws Exception
     */
    public function isLogleser ($userId)
    {
        $db = $this->getDbTable('User')->getDefaultAdapter();
        $result = $db->query('SELECT * FROM logleser WHERE userId = ?', [$userId]);
        return count($result->fetchAll()) > 0;
    }

    /**
     * @param $userId
     *
     * @return bool
     * @throws Exception
     */
    public function hasChara ($userId)
    {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->where('userId = ? AND active = 1', $userId);
        $result = $this->getDbTable('User')->fetchAll($select);

        return $result->count() > 0;
    }

    /**
     * @param $userId
     *
     * @return bool
     * @throws Exception
     */
    public function isAdmin ($userId)
    {
        $select = $this->getDbTable('Admins')->select();
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('Admins')->fetchAll($select);

        return $result->count() > 0;
    }

    /**
     * @param $userId
     *
     * @return mixed
     * @throws Exception
     */
    public function countNewPm ($userId)
    {
        $select = $this->getDbTable('Pm')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachrichten');
        $select->where('empfaengerId = ? AND status = "ungelesen"', $userId);
        $result = $this->getDbTable('Pm')->fetchAll($select);
        return $result->count();
    }

    /**
     * @param $userId
     *
     * @return bool
     * @throws Exception
     */
    public function getAdminnameById ($userId)
    {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('benutzerdaten');
        $select->where('userId = ?', $userId);
        $row = $this->getDbTable('User')->fetchRow($select);
        if ($row !== null) {
            return $row->profilname;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param Application_Model_User $user
     * @param $ip
     *
     * @return mixed
     * @throws Exception
     */
    public function createUser (Application_Model_User $user, $ip)
    {
        $datetime = new DateTime();
        $data['username'] = $user->getUsername();
        $data['profilname'] = $user->getProfilname();
        $data['passwort'] = $this->generateHash($user->getPasswort());
        $data['mail'] = $user->getEmail();
        $data['usergruppe'] = $user->getUsergruppe();
        $data['adminname'] = null;
        $data['logintime'] = null;
        $data['logouttime'] = null;
        $data['registertime'] = $datetime->format('Y-m-d H:i:s');
        $data['ip'] = $ip;
        return $this->getDbTable('User')->insert($data);
    }

    /**
     * @param type $userId
     *
     * @return \Application_Model_User
     * @throws Exception
     */
    public function getUserById ($userId)
    {
        $user = new Application_Model_User();
        $select = $this->getDbTable('User')->select();
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchRow($select);
        if ($result !== false) {
            $user->setId($userId);
            $user->setProfilname($result['profilname']);
            $user->setUsername($result['username']);
            $user->setPasswort($result['passwort']);
            $user->setEmail($result['mail']);
            $user->setUsergruppe($result['usergruppe']);
        }
        return $user;
    }

    /**
     * @param string $password
     *
     * @return string
     * @todo
     *
     */
    function generateHash ($password)
    {
        return md5($password);
        //        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        //            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        //            return crypt($password, $salt);
        //        }
    }

    /**
     * @param int $userId
     * @param string $newMail
     *
     * @return int
     * @throws Exception
     */
    public function changeEmail ($userId, $newMail)
    {
        $data['mail'] = $newMail;
        return $this->getDbTable('User')->update($data, ['userId = ?' => $userId]);
    }

    /**
     * @param int $userId
     * @param string $newPassword
     *
     * @return int
     * @throws Exception
     */
    public function changePassword ($userId, $newPassword)
    {
        $data['passwort'] = $this->generateHash($newPassword);
        return $this->getDbTable('User')->update($data, ['userId = ?' => $userId]);
    }

    /**
     * @param int $userId
     *
     * @return int
     * @throws Exception
     */
    public function deleteUser ($userId)
    {
        $data['active'] = 0;
        return $this->getDbTable('User')->update($data, ['userId = ?' => $userId]);
    }

    /**
     * @param int $userId
     * @param string $password
     *
     * @return boolean
     * @throws Exception
     */
    public function verifyPassword ($userId, $password)
    {
        $select = $this->getDbTable('User')->select();
        $select->from('benutzerdaten', ['passwort']);
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchRow($select);
        if ($result !== null) {
            return $this->generateHash($password) === $result['passwort'];
        }
        return false;
    }

    /**
     * @param int $userId
     *
     * @return int
     * @throws Exception
     */
    public function logAction ($userId)
    {
        $datetime = new DateTime();
        $data['logintime'] = $datetime->format('Y-m-d H:i:s');
        return $this->getDbTable('User')->update($data, ['userId = ?' => $userId]);
    }

    /**
     * @return Application_Model_User[]
     * @throws Exception
     */
    public function getUsers ()
    {
        $returnArray = [];
        $select = $this->getDbTable('User')
            ->select()
            ->from('benutzerdaten', ['userId', 'username', 'usergruppe', 'profilname'])
            ->joinLeft('charakter', 'charakter.userId = benutzerdaten.userId and charakter.active = 1', [])
            ->where('benutzerdaten.active = 1')
            ->order(new Zend_Db_Expr('benutzerdaten.usergruppe = "Admin" DESC'))
            ->order(new Zend_Db_Expr('charakter.vorname IS NULL ASC'))
            ->order('charakter.vorname')
            ->order('benutzerdaten.profilname');
        $result = $this->getDbTable('User')->fetchAll($select);
        foreach ($result as $row) {
            $user = new Application_Model_User();
            $user->setUsername($row->username);
            $user->setProfilname($row->profilname);
            $user->setUsergruppe($row->usergruppe);
            $user->setId($row->userId);
            $returnArray[] = $user;
        }
        return $returnArray;
    }

    /**
     * @return Application_Model_User[]
     */
    public function getActiveUsers ()
    {
        $returnArray = [];
        try {
            $select = $this->getDbTable('User')->select()->where('active=1');
            $result = $this->getDbTable('User')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        foreach ($result as $row) {
            $user = new Application_Model_User();
            $user->setUsername($row->username);
            $user->setProfilname($row->profilname);
            $user->setUsergruppe($row->usergruppe);
            $user->setId($row->userId);
            $returnArray[] = $user;
        }
        return $returnArray;
    }


    /**
     * @param $username
     *
     * @return bool
     * @throws Exception
     */
    public function usernameExists ($username)
    {
        $select = $this->getDbTable('User')->select();
        $select->where('username = ?', $username);
        $result = $this->getDbTable('User')->fetchAll($select);
        return $result->count() > 0;
    }


    /**
     * @param $mail
     *
     * @return bool
     * @throws Exception
     */
    public function emailExists ($mail)
    {
        $select = $this->getDbTable('User')->select();
        $select->where('mail = ? AND active = 1', $mail);
        $result = $this->getDbTable('User')->fetchAll($select);
        return $result->count() > 0;
    }


    /**
     * @param $profilname
     *
     * @return bool
     * @throws Exception
     */
    public function profilnameExists ($profilname)
    {
        $select = $this->getDbTable('User')->select();
        $select->where('profilname = ?', $profilname);
        $result = $this->getDbTable('User')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param string $username
     * @param string $email
     *
     * @return boolean
     * @throws Exception
     */
    public function usernameAndEmailExists ($username, $email)
    {
        $select = $this->getDbTable('User')->select();
        $select->where('username = ?', $username);
        $select->where('mail = ? AND active = 1', $email);
        $row = $this->getDbTable('User')->fetchRow($select);
        if ($row !== null) {
            return $row['userId'];
        } else {
            throw new Exception('Username und Email Kombination existieren nicht.');
        }
    }

}
