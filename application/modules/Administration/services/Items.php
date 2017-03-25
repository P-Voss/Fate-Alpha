<?php

/**
 * Description of Administration_Service_Items
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Items {
    
    /**
     * @var Administration_Model_Mapper_ItemMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_ItemMapper();
    }
    
    
    public function createItem(Zend_Controller_Request_Http $request) {
        
    }
    
    
    public function editItem(Zend_Controller_Request_Http $request) {
        
    }
    
    
    public function getItemList(Zend_Controller_Request_Http $request) {
        
    }
    
    
    public function getItemById($itemId) {
        
    }
    
    
    public function deleteItem($itemId) {
        
    }
    
}
