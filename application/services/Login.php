<?php

class Application_Service_Login{
    
    /**
     * @var Application_Model_Mapper_UserMapper 
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Application_Model_Mapper_UserMapper();
    }
 
    public function login(Zend_Controller_Request_Http $request){
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter,'benutzerdaten', 'username', 'passwort', 'MD5(?) AND active=1');

//        $authAdapter->setTableName('benutzerdaten')
//                    ->setIdentityColumn('username')
//                    ->setCredentialColumn('passwort')
//                    ->setCredentialTreatment('MD5(?)');
//        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setIdentity($request->getPost('username'));
        $authAdapter->setCredential($request->getPost('passwort'));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()){
            $auth->getStorage()->write($authAdapter->getResultRowObject());
            $this->mapper->logAction($auth->getIdentity()->userId);
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
    
    /**
     * @param type $username
     * @param type $email
     * @return type
     */
    public function getUserIdByUsernameAndEmail($username, $email) {
        return $this->mapper->usernameAndEmailExists($username, $email);
    }
    
    
    public function resetPassword($userId) {
       $newPassword = $this->createPassword();
       if ($this->mapper->changePassword($userId, $newPassword)) {
           return $newPassword;
       }
       return false;
    }
    
    /**
     * @return string
     */
    private function createPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 14; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    
    public function sendPassword($email, $password) {
        $txt = <<<MAIL
Hallo,
dein neues Passwort lautet: {$password}
MAIL;
        $mail = new Zend_Mail();
        $mail->setFrom('noreply@fate-alpha.de', 'Fate Passwortservice');
        $mail->addTo($email);
        $mail->setSubject('Neues Passwort');
        $mail->setBodyText($txt);
        $mail->send();
    }
    
}

