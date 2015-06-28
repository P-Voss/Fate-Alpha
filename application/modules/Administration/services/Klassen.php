<?php

/**
 * Description of Nachteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Klassen {
    
    /**
     * @var Administration_Model_Mapper_NewsMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_NewsMapper();
    }
    
    public function createNews(Zend_Controller_Request_Http $request, $userId) {
        $news = new Administration_Model_News();
        $date = new DateTime();
        $news->setDatum($date->format('Y-m-d H:i:s'));
        $news->setTitel($request->getPost('Titel'));
        $news->setNachricht($request->getPost('Nachricht'));
        $news->setVerfasser($userId);
        return $this->mapper->createNews($news);
    }
    
    public function editNews(Zend_Controller_Request_Http $request, $userId) {
        $news = new Administration_Model_News();
        $date = new DateTime();
        $news->setId($request->getPost('newsId'));
        $news->setEditdatum($date->format('Y-m-d H:i:s'));
        $news->setTitel($request->getPost('Titel'));
        $news->setNachricht($request->getPost('Nachricht'));
        $news->setEditor($userId);
        return $this->mapper->updateNews($news);
    }
    
    public function getNewsById($newsId) {
        return $this->mapper->getNewsById($newsId);
    }
    
    public function getNewsList() {
        return $this->mapper->getNews();
    }
    
    public function deleteNews(Zend_Controller_Request_Http $request) {
        return $this->mapper->deleteNews($request->getPost('newsId'));
    }
    
}
