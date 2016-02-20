<?php

/**
 * Description of File
 *
 * @author Voß
 */
class Gruppen_Service_File {
    
    
    public function uploadLog(Zend_Controller_Request_Http $request, $userId) {
        $mapper = new Gruppen_Model_Mapper_LogMapper();
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->getMimeType('logfile') !== 'application/pdf'){
            return false;
        }
        $hash = $upload->getHash('md5', 'logfile');
        $fileinfo = $upload->getFileInfo();
        $filename = $fileinfo['logfile']['name'];
        
        $log = new Application_Model_Log();
        $log->setMd5($hash);
        $log->setName($filename);
        $log->setOwner(Zend_Auth::getInstance()->getIdentity()->userId);
        $date = new DateTime();
        $log->setCreatedate($date->format('Y-m-d H:i:s'));
        if(!is_null($request->getPost('plot'))){
            $log->setPlotId($request->getPost('plot'));
        }
        
        if($mapper->checkIfExists($log) === true){
            return false;
        }
        
        $upload->addFilter('Rename', APPLICATION_PATH.'/var/logs/' . $hash);
        $upload->receive();
        
        $logId = $mapper->saveLog($log);
        $mapper->connectGroupToLog($logId, $request->getPost('gruppenId'));
    }
    
}
