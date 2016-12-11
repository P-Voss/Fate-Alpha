<?php

/**
 * Description of Story_Model_Mapper_LogMapper
 *
 * @author Voß
 */
class Story_Model_Mapper_LogMapper extends Application_Model_Mapper_LogMapper {
    
    /**
     * @param Story_Model_Log $log
     * @return int
     */
    public function saveLog(Story_Model_Log $log) {
        $data = array(
            'name' => $log->getName(),
            'beschreibung' => $log->getBeschreibung(),
            'md5' => $log->getMd5(),
            'owner' => $log->getOwner(),
            'createDate' => $log->getCreatedate('Y-m-d H:i:s'),
            'episodenId' => $log->getEpisodenId(),
        );
        return $this->getDbTable('Logs')->insert($data);
    }
    
    /**
     * @param int $episodenId
     * @return \Story_Model_Log
     */
    public function getLogsByEpisodenId($episodenId) {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT name, beschreibung, logId FROM logs WHERE episodenId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId]);
        foreach ($stmt->fetchAll() as $row) {
            $log = new Story_Model_Log();
            $log->setId($row['logId']);
            $log->setName($row['name']);
            $log->setBeschreibung($row['beschreibung']);
            $returnArray[] = $log;
        }
        return $returnArray;
    }
    
    /**
     * @param int $logId
     * @param int $episodeId
     * @return \Story_Model_Log
     */
    public function getLogByLogIdAndEpisodeId($logId, $episodeId) {
        $log = new Story_Model_Log();
        $select = $this->getDbTable('Logs')->select();
        $select->where('logId = ?', $logId);
        $select->where('episodenId = ?', $episodeId);
        $result = $this->getDbTable('Logs')->fetchRow($select);
        if($result !== null){
            $log->setId($result->logId);
            $log->setName($result->name);
            $log->setEpisodenId($result->episodenId);
            $log->setMd5($result->md5);
        }
        return $log;
    }
    
}
