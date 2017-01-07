<?php

/**
 * Description of Application_Service_Cache
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Cache {
    
    /**
     * @var Memcached 
     */
    private $cache;
    /**
     * @var boolean
     */
    private $isActive = false;
    
    /**
     * @return boolean
     */
    public function __construct() {
        try {
            $this->cache = new Memcached();
        } catch (Error $exc) {
            $this->isActive = false;
            return false;
        }
        if (count($this->cache->getServerList()) > 0) {
            $this->isActive = true;
        } else {
            $this->isActive = $this->cache->addServer('localhost', 11211);
        }
    }
    
    
    public function isActive() {
        return false;
    }
    
    /**
     * @param int $charakterId
     * @return boolean
     */
    public function fetch($category, $key) {
        $serializedData = $this->cache->get($category . md5($key));
        if ($serializedData === false) {
            return false;
        }
        return unserialize($serializedData);
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     */
    public function storeCharakter($category, $key, $unserializedData) {
        $this->cache->set($category . md5($key), serialize($unserializedData), 60*60*24);
    }
    
}
