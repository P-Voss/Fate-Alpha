<?php


/**
 * Description of News
 *
 * @author Vosser
 */
class Application_Service_News {
    
    public function getNews() {
        $mapper = new Application_Model_Mapper_NewsMapper();
        return $mapper->getNews();
    }
    
}
