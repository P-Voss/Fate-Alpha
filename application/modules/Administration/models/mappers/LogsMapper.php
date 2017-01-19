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
        $sql = 'SELECT episode.episodenId, episode.name 
                FROM episoden
                INNER JOIN episodenAuswertung AS ausw
                    ON ausw.episodenId = episoden.episodenId AND ausw.isActive = 1 -- AND ausw.isAccepted = 1 
                INNER JOIN episoden AS episode
                    ON episode.episodenId = episoden.episodenId
                WHERE 
                    episoden.statusId = 4
                GROUP BY 
                    episoden.episodenId';
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
    
    /**
     * @param int $episodeId
     * @return Administration_Model_Episode
     */
    public function getEpisodeToReview($episodeId) {
        $episode = new Administration_Model_Episode();
        $select = $this->getDbTable('Episoden')->select();
        $select->where('episodenId = ?', $episodeId);
        $result = $this->getDbTable('Episoden')->fetchRow($select);
        if($result !== null){
            $episode->setId($result->episodenId);
            $episode->setName($result->name);
        }
        return $episode;
    }
    
    
    public function getLogreaderResults($episodeId) {
        $returnArray = [];
        $select = $this->getDbTable('Episoden')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenAuswertung');
        $select->joinInner('benutzerdaten', 
                'benutzerdaten.userId = episodenAuswertung.userId', 
                array('profilname')
        );
        $select->where('episodenId = ?', $episodeId);
        $result = $this->getDbTable('Episoden')->fetchAll($select);
        foreach ($result as $row) {
            $auswertung = new Administration_Model_Auswertung();
            $auswertung->setDescription($row->feedback);
            $auswertung->setIsAccepted($row->isAccepted === 1);
            $auswertung->setProfilname($row->profilname);
            $auswertung->setUserId($row->userId);
            $returnArray[] = $auswertung;
        }
        return $returnArray;
    }
    
    
    public function insertRejection($episodeId, Administration_Model_Auswertung $auswertung) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'INSERT INTO episodenRejection (episodenId, userId, reason, isActive) VALUES (?, ?, ?, 1)';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'episodenId' => $episodeId,
            'userId' => $auswertung->getUserId(),
            'reason' => $auswertung->getDescription(),
        ]);
    }
    
    public function updateStatus($episodeId, $statusId) {
        $data = [
            'statusId' => $statusId,
        ];
        $this->getDbTable('Episoden')->update($data, ['episodenId = ?' => $episodeId]);
    }
    
    
}
