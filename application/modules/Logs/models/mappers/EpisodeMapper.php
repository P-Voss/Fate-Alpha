<?php

/**
 * Description of Story_Model_Mapper_EpisodeMapper
 *
 * @author Voß
 */
class Logs_Model_Mapper_EpisodeMapper extends Application_Model_Mapper_EpisodeMapper {

    /**
     * @param int $episodenId
     *
     * @return boolean
     * @throws Exception
     */
    public function episodeBelongsToSecretPlot($episodenId) {
        $select = $this->getDbTable('Episoden')
            ->select()
            ->setIntegrityCheck(false)
            ->from('episoden', [])
            ->joinInner('plots', 'plots.plotId = episoden.plotId AND plots.isSecret = 1')
            ->where('episoden.episodenId = ?', $episodenId);
        $result = $this->getDbTable('Episoden')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param type $plotId
     * @param type $userId
     * @return array
     * @throws Exception
     */
    public function getEpisodesToReviewByPlotId($plotId, $userId) {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT episoden.episodenId, episoden.name
                FROM episoden 
                LEFT JOIN episodenAuswertung AS auswertung
                    ON auswertung.episodenId = episoden.episodenId 
                    AND auswertung.userId = ? AND auswertung.isActive = 1
                WHERE 
                    episoden.plotId = ? 
                    AND episoden.statusId = 4 
                    AND auswertung.episodenId IS NULL
                ';
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId, $plotId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Logs_Model_Episode();
            $episode->setId($row['episodenId']);
            $episode->setName($row['name']);
            $returnArray[] = $episode;
        }
        return $returnArray;
    }

    /**
     * @param int $plotId
     * @return array
     * @throws Exception
     */
    public function getEpisodesByPlotId($plotId) {
        $returnArray = array();
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT 
                    episoden.episodenId,
                    episoden.name,
                    episoden.creationdate,
                    episodenStatus.statusId,
                    episodenStatus.status,
                    episodenStatus.colorCode
                FROM episoden
                LEFT JOIN (SELECT episodenId, count(*) 
                            FROM episodenOutcomes 
                            GROUP BY episodenId
                ) AS outcomes USING (episodenId)
                INNER JOIN episodenStatus USING (statusId)
                WHERE episoden.plotId = ?
                ';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($plotId));
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Logs_Model_Episode();
            $episodenStatus = new Logs_Model_EpisodenStatus();
            $episodenStatus->setId($row['statusId']);
            $episodenStatus->setStatus($row['status']);
            $episodenStatus->setColorCode($row['colorCode']);
            $episode->setId($row['episodenId']);
            $episode->setName($row['name']);
            $episode->setCreateDate($row['creationdate']);
            $episode->setStatus($episodenStatus);
            $returnArray[] = $episode;
        }
        return $returnArray;
    }

    /**
     * @param int $episodeId
     * @return Logs_Model_Episode
     * @throws Exception
     */
    public function getEpisodeToJudgeById($episodeId) {
        $episode = new Logs_Model_Episode();
        $status = new Logs_Model_EpisodenStatus();
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT 
                    episoden.episodenId, episoden.name, episoden.creationdate, episoden.plotId,
                    eO.outcome, eO.creationdate AS outcomedate,
                    eD.description, eD.creationdate AS descriptiondate,
                    episodenStatus.statusId, episodenStatus.status, episodenStatus.colorCode
                FROM episoden
                LEFT JOIN (SELECT episodenId, MAX(creationdate) AS creationdate
                            FROM episodenOutcomes 
                            GROUP BY episodenId
                ) AS outcomes USING (episodenId)
                LEFT JOIN (SELECT episodenId, MAX(creationdate) AS creationdate
                            FROM episodenDescriptions 
                            GROUP BY episodenId
                ) AS descriptions USING (episodenId)
                LEFT JOIN episodenDescriptions AS eD
                    ON eD.episodenId = descriptions.episodenId AND eD.creationdate = descriptions.creationdate
                LEFT JOIN episodenOutcomes AS eO
                    ON eO.episodenId = outcomes.episodenId AND eO.creationdate = outcomes.creationdate
                INNER JOIN episodenStatus USING (statusId)
                WHERE episoden.episodenId = ?
                ';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($episodeId));
        $result = $stmt->fetch();
        if($result !== false){
            $episode->setName($result['name']);
            $episode->setId($episodeId);
            $episode->setPlotId($result['plotId']);
            $episode->setBeschreibung($result['description']);
            $episode->setZusammenfassung($result['outcome']);
            $status->setId($result['statusId']);
            $status->setStatus($result['status']);
            $status->setColorCode($result['colorCode']);
            $episode->setStatus($status);
            return $episode;
        } else {
            throw new Exception('Episode not found');
        }
    }

    /**
     * @param int $episodenId
     * @return array
     * @throws Exception
     */
    public function getParticipants($episodenId) {
        $returnArray = array();
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', array());
        $select->joinInner('charakter', 'charakter.charakterId = episodenToCharakter.charakterId AND charakter.active = 1');
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $result = $this->getDbTable('EpisodenCharakter')->fetchAll($select);
        foreach ($result as $row) {
            $charakter = new Story_Model_Charakter();
            $charakter->setCharakterid($row['charakterId']);
            $charakter->setVorname($row['vorname']);
            $charakter->setNachname($row['nachname']);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param int $episodenId
     * @return Logs_Model_Charakter[]
     * @throws Exception
     */
    public function getParticipantsByEpisode($episodenId) {
        $returnArray = array();
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', array());
        $select->joinInner('charakter', 'charakter.charakterId = episodenToCharakter.charakterId AND charakter.active = 1');
        $select->joinInner('episodenCharakterResult', 
                'episodenCharakterResult.episodenId = episodenToCharakter.episodenId 
                    AND episodenCharakterResult.charakterId = episodenToCharakter.charakterId',
                [
                    'gotKilled', 'npcsKilled', 'comment',
                ]);
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $result = $this->getDbTable('EpisodenCharakter')->fetchAll($select);
        foreach ($result as $row) {
            $charakter = new Logs_Model_Charakter();
            $result = new Logs_Model_CharakterResult();
            $result->setKillNpcs($row['npcsKilled']);
            $result->setDied($row['gotKilled']);
            $result->setComment($row['comment']);
            
            $charakter->setCharakterid($row['charakterId']);
            $charakter->setVorname($row['vorname']);
            $charakter->setNachname($row['nachname']);
            $charakter->setResult($result);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param int $episodenId
     * @param int $charakterId
     * @return Logs_Model_CharakterResult
     * @throws Exception
     */
    public function getCharakterResult($episodenId, $charakterId) {
        $result = new Logs_Model_CharakterResult();
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', array());
        $select->joinInner('episodenCharakterResult', 
                'episodenCharakterResult.episodenId = episodenToCharakter.episodenId 
                    AND episodenCharakterResult.charakterId = episodenToCharakter.charakterId',
                [
                    'gotKilled', 'npcsKilled', 'comment',
                ]);
        $select->where('episodenToCharakter.charakterId = ?', $charakterId);
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $row = $this->getDbTable('EpisodenCharakter')->fetchRow($select);
        if($row !== null){
            $result = new Logs_Model_CharakterResult();
            $result->setKillNpcs($row['npcsKilled']);
            $result->setDied($row['gotKilled']);
            $result->setComment($row['comment']);
            $result->setRequestedMagien($this->getRequestedMagien($episodenId, $charakterId));
            $result->setRequestedSkills($this->getRequestedSkills($episodenId, $charakterId));
            $result->setCharaktersKilled($this->getRequestedCharakterKills($episodenId, $charakterId));
        }
        return $result;
    }

    /**
     * @param int $episodenId
     * @param int $charakterId
     * @return array
     * @throws Exception
     */
    public function getRequestedCharakterKills($episodenId, $charakterId) {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT charakter.charakterId, charakter.vorname, charakter.nachname 
                FROM episodenKillRequest AS eKR
                INNER JOIN charakter 
                    ON eKR.killedId = charakter.charakterId
                INNER JOIN episodenToCharakter AS eTC
                    ON eTC.charakterId = eKR.killedId AND eTC.episodenId = eKR.episodenId
                WHERE eKR.episodenId = ? AND eKR.charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $charakterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $charakter = new Application_Model_Charakter();
            $charakter->setCharakterid($row['charakterId']);
            $charakter->setVorname($row['vorname']);
            $charakter->setNachname($row['nachname']);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }
    
    
    private function getRequestedSkills($episodenId, $charakterId) {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT skillId, name 
                FROM episodenCharakterSkillRequest AS eCSR
                INNER JOIN skills 
                    ON eCSR.art = "skill" 
                    AND eCSR.id = skills.skillId
                    AND request = "add"
                WHERE episodenId = ? AND charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $charakterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row['skillId']);
            $skill->setBezeichnung($row['name']);
            $returnArray[] = $skill;
        }
        return $returnArray;
    }
    
    
    private function getRequestedMagien($episodenId, $charakterId) {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT magieId, name 
                FROM episodenCharakterSkillRequest AS eCSR
                INNER JOIN magien 
                    ON eCSR.art = "magie" 
                    AND request = "add" 
                    AND eCSR.id = magien.magieId
                WHERE episodenId = ? AND charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $charakterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $magie = new Story_Model_Magie();
            $magie->setId($row['magieId']);
            $magie->setBezeichnung($row['name']);
            $returnArray[] = $magie;
        }
        return $returnArray;
    }

    /**
     * @param Logs_Model_EpisodenStatus $newStatus
     * @param int $episodenId
     * @throws Exception
     */
    public function updateStatus(Logs_Model_EpisodenStatus $newStatus, $episodenId) {
        $data = [
            'statusId' => $newStatus->getId(),
        ];
        $this->getDbTable('Episoden')->update($data, ['episodenId = ?' => $episodenId]);
    }

    /**
     * @param int $episodenId
     * @param int $charakterId
     * @param int $killcount
     * @throws Exception
     */
    public function updateCharakterNpckills($episodenId, $charakterId, $killcount) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare('UPDATE episodenCharakterResult
                                SET npcsKilled = ?
                                WHERE episodenId = ? AND charakterId = ?');
        $stmt->execute([$killcount, $episodenId, $charakterId]);
    }

    /**
     * @param int $episodenId
     * @param int $charakterId
     * @param int $gotKilled
     * @throws Exception
     */
    public function updateCharakterGotKilled($episodenId, $charakterId, $gotKilled) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare('UPDATE episodenCharakterResult
                                SET gotKilled = ?
                                WHERE episodenId = ? AND charakterId = ?');
        $stmt->execute([$gotKilled === 'true' ? 1 : 0, $episodenId, $charakterId]);
    }
    
    
    public function removeCharakterKillRequests($episodenId, $charakterId) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare('DELETE FROM episodenKillRequest
                                WHERE episodenId = ? AND charakterId = ?');
        $stmt->execute([$episodenId, $charakterId]);
    }

    /**
     * @param Logs_Model_Auswertung $auswertung
     * @param int $episodenId
     * @throws Exception
     */
    public function removeAuswertung(Logs_Model_Auswertung $auswertung, $episodenId) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'DELETE FROM episodenAuswertung WHERE episodenId = ? AND userId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $auswertung->getUserId()]);
    }

    /**
     * @param Logs_Model_Auswertung $auswertung
     * @param int $episodenId
     * @throws Exception
     */
    public function saveAuswertung(Logs_Model_Auswertung $auswertung, $episodenId) {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'INSERT INTO episodenAuswertung (episodenId, userId, feedback, isAccepted, isActive)
                VALUES (?, ?, ?, ?, 1)';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $episodenId, $auswertung->getUserId(), $auswertung->getDescription(), (int) $auswertung->getIsAccepted(),
        ]);
    }
    
}
