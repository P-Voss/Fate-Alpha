<?php


class Administration_Model_Mapper_LogsMapper {
    
    
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
    
    /**
     * @return \Administration_Model_Episode
     */
    public function getEpisodesToReview() {
        $returnArray = array();
        $sql = 'SELECT episoden.episodenId, episoden.name FROM episoden WHERE statusId = 4';
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Administration_Model_Episode();
            $episode->setId($row['episodenId']);
            $episode->setName($row['name']);
            $returnArray[] = $episode;
        }
        return $returnArray;
    }
    
}
