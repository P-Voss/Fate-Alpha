<?php

class Administration_Model_Mapper_NewsMapper extends Application_Model_Mapper_NewsMapper {
    
    public function createNews(Administration_Model_News $news) {
        $data['titel'] = $news->getTitel();
        $data['nachricht'] = $news->getNachricht();
        $data['verfasserUserId'] = $news->getVerfasser();
        $data['creationDate'] = $news->getDatum('Y-m-d H:i:s');
        return parent::getDbTable('News')->insert($data);
    }
    
    public function getNewsById($newsId) {
        $news = new Administration_Model_News();
        $select = parent::getDbTable('News')->select();
        $select->where('newsId = ?', $newsId);
        $row = parent::getDbTable('News')->fetchRow($select);
        if($row !== null){
            $news->setId($row['newsId']);
            $news->setTitel($row['titel']);
            $news->setNachricht($row['nachricht']);
            $news->setVerfasser($row['verfasserUserId']);
            $news->setDatum($row['creationDate']);
            $news->setEditor($row['editUserId']);
            $news->setEditdatum($row['editDate']);
        }
        return $news;
    }
    
    public function updateNews(Administration_Model_News $news) {
        $data['titel'] = $news->getTitel();
        $data['nachricht'] = $news->getNachricht();
        $data['editUserId'] = $news->getEditor();
        $data['editDate'] = $news->getEditdatum('Y-m-d H:i:s');
        return parent::getDbTable('News')->update($data, array('newsId = ?' => $news->getId()));
    }
    
    public function deleteNews($newsId) {
        return parent::getDbTable('News')->delete(array('newsId = ?' => $newsId));
    }
    
}
