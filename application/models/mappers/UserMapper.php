<?php

class Application_Model_Mapper_UserMapper {

    protected $dbTableUser;
    protected $dbTablePm;

    public function getDbTableUser() {
        if (null === $this->dbTableUser) {
            $this->setDbTableUser('Application_Model_DbTable_User');
        }
        return $this->dbTableUser;
    }

    public function setDbTableUser($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableUser = $dbTable;
        return $this;
    }

    public function getDbTablePm() {
        if (null === $this->dbTablePm) {
            $this->setDbTablePm('Application_Model_DbTable_Pm');
        }
        return $this->dbTablePm;
    }

    public function setDbTablePm($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTablePm = $dbTable;
        return $this;
    }

    public function hasChara($userid) {
        $select = $this->getDbTableUser()->select();
        $select->setIntegrityCheck(false);
        $select->from('Charakter');
        $select->where('userID = ?', $userid);
        $result = $this->getDbTableUser()->fetchAll($select);
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function countNewPm($userid) {
        $select = $this->getDbTablePm()->select();
        $select->setIntegrityCheck(false);
        $select->from('NachrichtenEingang');
        $select->where('Empfaenger = ? AND Status = "Ungelesen"', $userid);
        $result = $this->getDbTablePm()->fetchAll($select);
        return $result->count();
    }

    public function getAdminnameById($userid) {
        $select = $this->getDbTableUser()->select();
        $select->setIntegrityCheck(false);
        $select->from('Benutzerdaten');
        $select->where('id = ?', $userid);
        $result = $this->getDbTableUser()->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                return $row->Profilname;
            }
        } else {
            return false;
        }
    }

    public function getCharakterById($userid) {
        
    }

    public function createUser(Application_Model_User $user, $ip) {
        $datetime = new DateTime();
        $data['Username'] = $user->getUsername();
        $data['Profilname'] = $user->getProfilname();
        $data['Passwort'] = $this->generateHash($user->getPasswort());
        $data['Email'] = $user->getEmail();
        $data['Usergruppe'] = $user->getUsergruppe();
        $data['Adminname'] = null;
        $data['Loginzeitpunkt'] = null;
        $data['Logoutzeitpunkt'] = null;
        $data['Anmeldedatum'] = $datetime->format('Y-m-d H:i:s');
        $data['ip'] = $ip;
        $this->getDbTableUser()->insert($data);
    }

    function generateHash($password) {
        return md5($password);
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }

}

?>