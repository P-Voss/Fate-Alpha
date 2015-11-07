<?php

class Application_Model_Mapper_UserMapper {

    
    public function getDbTable($tablename) {
        $className = 'Application_Model_DbTable_' . $tablename;
        if(!class_exists($className)){
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if(!$dbTable instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    public function hasChara($userId) {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchAll($select);
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin($userId) {
        $select = $this->getDbTable('Admins')->select();
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('Admins')->fetchAll($select);
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function countNewPm($userId) {
        $select = $this->getDbTable('Pm')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachrichten');
        $select->where('empfaengerId = ? AND status = "ungelesen"', $userId);
        $result = $this->getDbTable('Pm')->fetchAll($select);
        return $result->count();
    }

    public function getAdminnameById($userId) {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('benutzerdaten');
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                return $row->profilname;
            }
        } else {
            return false;
        }
    }

    public function createUser(Application_Model_User $user, $ip) {
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
        $this->getDbTable('User')->insert($data);
    }
    
    /**
     * @param type $userId
     * @return \Application_Model_User
     */
    public function getUserById($userId) {
        $user = new Application_Model_User();
        $select = $this->getDbTable('User')->select();
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchRow($select);
        if($result !== false){
            $user->setId ($userId);
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
     * @return string
     */
    function generateHash($password) {
        return md5($password);
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }
    
    /**
     * @param int $userId
     * @param string $newMail
     * @return int
     */
    public function changeEmail($userId, $newMail) {
        $data['mail'] = $newMail;
        return $this->getDbTable('User')->update($data, array('userId = ?' => $userId));
    }
    
    /**
     * @param int $userId
     * @param string $newPassword
     * @return int
     */
    public function changePassword($userId, $newPassword) {
        $data['passwort'] = $this->generateHash($newPassword);
        return $this->getDbTable('User')->update($data, array('userId = ?' => $userId));
    }
    
    /**
     * @param int $userId
     * @return int
     */
    public function deleteUser($userId) {
        $data['active'] = 0;
        return $this->getDbTable('User')->update($data, array('userId = ?' => $userId));
    }
    
    /**
     * @param int $userId
     * @param string $password
     * @return boolean
     */
    public function verifyPassword($userId, $password) {
        $select = $this->getDbTable('User')->select();
        $select->from('benutzerdaten', array('passwort'));
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('User')->fetchRow();
        if($result !== null){
            return $this->generateHash($password) === $result['passwort'];
        }
        return false;
    }
    
    /**
     * @param int $userId
     * @return int
     */
    public function logAction($userId) {
        $datetime = new DateTime();
        $data['logintime'] = $datetime->format('Y-m-d H:i:s');
        return $this->getDbTable('User')->update($data, array('userId = ?' => $userId));
    }
    
    /**
     * @return \Application_Model_User
     */
    public function getUsers() {
        $returnArray = array();
        $result = $this->getDbTable('User')->fetchAll();
        foreach ($result as $row) {
            $user = new Application_Model_User();
            $user->setUsername($row->username);
            $user->setProfilname($row->profilname);
            $user->setId($row->userId);
            $returnArray[] = $user;
        }
        return $returnArray;
    }

}
