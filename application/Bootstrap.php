<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    
    public function _initConfig() {
        $zendconf = new Zend_Config_Ini(APPLICATION_PATH
                . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('zendconf', $zendconf);
        Zend_Registry::set('env', APPLICATION_ENV);
        Zend_Registry::set('path', APPLICATION_PATH);
        
    }
    
    public function _initAutoloader() {

        $autoloader = Zend_Loader_Autoloader::getInstance();

        $autoloader->registerNamespace('application_');
        $autoloader->registerNamespace('PHPExcel_');
        $autoloader->registerNamespace('PHPExcel');
        $autoloader->registerNamespace('Spreadsheet_');
        $autoloader->registerNamespace('Spreadsheet');
        Zend_Registry::set('autoloader', $autoloader);
        
    }
    
    public function _initDoctype(){
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('<!DOCTYPE html>');
    }
    
    public function _initPurififer() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $config = HTMLPurifier_Config::createDefault();
        $view->purifier = new HTMLPurifier($config);
    }
    
//    public function _initAutoversioning() {
//        $this->bootstrap('view');
//        $view = $this->getResource('view');
//        $f = function ($file) {
//            if (strpos($file, '/') !== 0 
//                || 
//                !file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) 
//            {
//                return $file;
//            }
//            $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
//            return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
//        };
//        $view->autoVersion = $f;
//    }

    public function _initDb() {
        $this->bootstrap('multidb');
        $resource = $this->getPluginResource('multidb');
        foreach ($resource->getOptions() as $key => $value) {
            Zend_Registry::set($key, $resource->getDb($key));
        }
    }
    
    public function _initHelpers() {
        require_once APPLICATION_PATH . '/controllers/helpers/Logincheck.php';
        require_once APPLICATION_PATH . '/controllers/helpers/Admincheck.php';
        Zend_Controller_Action_HelperBroker::addHelper(new Application_Controller_Helpers_Logincheck());
        Zend_Controller_Action_HelperBroker::addHelper(new Application_Controller_Helpers_Admincheck());
    }

}

