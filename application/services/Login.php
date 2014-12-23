<?php

class Application_Service_Login{
 
    public function login(Zend_Controller_Request_Http $request){
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('Benutzerdaten')
                    ->setIdentityColumn('Username')
                    ->setCredentialColumn('Passwort')
                    ->setCredentialTreatment('MD5(?)');
        
        $authAdapter->setIdentity($request->getPost('username'));
        $authAdapter->setCredential($request->getPost('passwort'));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()){
            $auth->getStorage()->write($authAdapter->getResultRowObject());
            return true;
        } else {
            switch ($result->getCode()) {
                case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->error = 'Benutzer nicht vorhanden';
                    break;
                case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                    $this->error = 'Passwort falsch';
                    break;
                default:
                    $this->error = 'Login fehlgeschlagen';
                    break;
            }
            return $this->error;
        }

    }
    
}

