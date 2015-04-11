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

    public function hasChara($userid) {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->where('userId = ?', $userid);
        $result = $this->getDbTable('User')->fetchAll($select);
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function countNewPm($userid) {
        $select = $this->getDbTable('Pm')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachrichtenEingang');
        $select->where('Empfaenger = ? AND Status = "Ungelesen"', $userid);
        $result = $this->getDbTable('Pm')->fetchAll($select);
        return $result->count();
    }

    public function getAdminnameById($userid) {
        $select = $this->getDbTable('User')->select();
        $select->setIntegrityCheck(false);
        $select->from('Benutzerdaten');
        $select->where('id = ?', $userid);
        $result = $this->getDbTable('User')->fetchAll($select);
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
        $this->getDbTable('User')->insert($data);
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