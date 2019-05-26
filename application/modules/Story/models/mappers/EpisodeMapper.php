<?php

/**
 * Description of Story_Model_Mapper_EpisodeMapper
 *
 * @author Voß
 */
class Story_Model_Mapper_EpisodeMapper extends Application_Model_Mapper_EpisodeMapper
{


    /**
     * @param int $episodenId
     * @param int $userId
     *
     * @return boolean
     */
    public function verifySl ($episodenId, $userId)
    {
        try {
            $db = $this->getDbTable('Plots')->getDefaultAdapter();
            $sql = 'SELECT
                    *
                    FROM episoden
                    INNER JOIN plots ON plots.userId = ? AND plots.plotId = episoden.plotId
                    WHERE episoden.episodenId = ?';
            $stmt = $db->prepare($sql);
            $stmt->execute([$userId, $episodenId]);
            return count($stmt->fetchAll()) > 0;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $episodenId
     * @param int $characterId
     *
     * @return boolean
     */
    public function verifyPlayer ($episodenId, $characterId)
    {
        try {
            $db = $this->getDbTable('Plots')->getDefaultAdapter();
            $sql = 'SELECT
                *
                FROM episodenToCharakter
                WHERE episodenId = ? AND charakterId = ?';
            $stmt = $db->prepare($sql);
            $stmt->execute([$episodenId, $characterId]);
            return count($stmt->fetchAll()) > 0;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $plotId
     *
     * @return array
     * @throws Exception
     */
    public function getEpisodesByPlotId ($plotId)
    {
        $returnArray = [];
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
        $stmt->execute([$plotId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Story_Model_Episode();
            $episodenStatus = new Story_Model_EpisodenStatus();
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
     * @param int $plotId
     *
     * @return array
     * @throws Exception
     */
    public function getActiveEpisodesByPlotId ($plotId)
    {
        $returnArray = [];
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
                WHERE episoden.plotId = ? AND episoden.statusId > 2
                ';
        $stmt = $db->prepare($sql);
        $stmt->execute([$plotId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Story_Model_Episode();
            $episodenStatus = new Story_Model_EpisodenStatus();
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
     * @param int $plotId
     * @param int $userId
     *
     * @return array
     * @throws Exception
     */
    public function getEpisodesByPlotIdForUser ($plotId, $userId)
    {
        $returnArray = [];
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
                INNER JOIN episodenToCharakter AS eTC 
                    ON eTC.episodenId = episoden.episodenId
                INNER JOIN charakter 
                    ON eTC.charakterId = charakter.charakterId 
                    AND charakter.userId = ?
                    AND charakter.active = 1
                WHERE episoden.plotId = ?
                ';
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId, $plotId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $episode = new Story_Model_Episode();
            $episodenStatus = new Story_Model_EpisodenStatus();
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
     *
     * @return Story_Model_Episode
     * @throws Exception
     */
    public function getEpisodeById ($episodeId)
    {
        $episode = new Story_Model_Episode();
        $status = new Story_Model_EpisodenStatus();
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
        $stmt->execute([$episodeId]);
        $result = $stmt->fetch();
        if ($result !== false) {
            $episode->setName($result['name']);
            $episode->setId($episodeId);
            $episode->setPlotId($result['plotId']);
            $episode->setBeschreibung($result['description']);
            $episode->setZusammenfassung($result['outcome']);
            $status->setId($result['statusId']);
            $status->setStatus($result['status']);
            $status->setColorCode($result['colorCode']);
            $episode->setStatus($status);
        }
        return $episode;
    }


    /**
     * @param Story_Model_Episode $episode
     *
     * @throws Exception
     */
    public function updateEpisode (Story_Model_Episode $episode)
    {
        $this->getDbTable('Episoden')->update(['name' => $episode->getName()], ['episodenId = ?' => $episode->getId()]);
    }


    /**
     * @param int $episodenId
     * @param array $characterIds
     *
     * @throws Exception
     */
    public function addParticipants ($episodenId, $characterIds = [])
    {
        $data['episodenId'] = $episodenId;
        foreach ($characterIds as $characterId) {
            $data['charakterId'] = $characterId;
            $this->getDbTable('EpisodenCharakter')->insert($data);
        }
    }

    /**
     * @param int $episodenId
     *
     * @throws Exception
     */
    public function removeParticipants ($episodenId)
    {
        $this->getDbTable('EpisodenCharakter')->delete(['episodenId = ?' => $episodenId]);
    }

    /**
     * @param int $episodenId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipants ($episodenId)
    {
        $returnArray = [];
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', []);
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
     * @param Story_Model_Episode $episode
     *
     * @return int
     * @throws Exception
     */
    public function createEpisode (Story_Model_Episode $episode)
    {
        $data = [
            'plotId' => $episode->getPlotId(),
            'name' => $episode->getName(),
        ];
        return $this->getDbTable('Episoden')->insert($data);
    }

    /**
     * @param Story_Model_Episode $episode
     *
     * @return int
     * @throws Exception
     */
    public function setBeschreibung (Story_Model_Episode $episode)
    {
        $data = [
            'episodenId' => $episode->getId(),
            'description' => $episode->getBeschreibung(),
        ];
        return $this->getDbTable('EpisodenDescription')->insert($data);
    }

    /**
     * @param Story_Model_Episode $episode
     *
     * @return int
     * @throws Exception
     */
    public function setZusammenfassung (Story_Model_Episode $episode)
    {
        $data = [
            'episodenId' => $episode->getId(),
            'outcome' => $episode->getZusammenfassung(),
        ];
        return $this->getDbTable('EpisodenOutcome')->insert($data);
    }

    /**
     * @param $episodeId
     * @param int $isReady
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsByEpisodeAndStatus ($episodeId, $isReady = 0)
    {
        $returnArray = [];
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', []);
        $select->joinInner('charakter', 'charakter.charakterId = episodenToCharakter.charakterId AND charakter.active = 1');
        $select->where('episodenToCharakter.episodenId = ?', $episodeId);
        $select->where('episodenToCharakter.isReady = ?', $isReady);
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
     *
     * @return Story_Model_Charakter[]
     * @throws Exception
     */
    public function getParticipantsByEpisode ($episodenId)
    {
        $returnArray = [];
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', []);
        $select->joinInner(
            'charakter',
            'charakter.charakterId = episodenToCharakter.charakterId AND charakter.active = 1',
            ['charakterId']
        );
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $result = $this->getDbTable('EpisodenCharakter')->fetchAll($select);
        foreach ($result as $row) {
            $charakter = new Story_Model_Charakter();
            $charakter->setCharakterid($row['charakterId']);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param $episodenId
     * @param int $characterId
     *
     * @return Story_Model_Charakter
     * @throws Exception
     */
    public function getParticipant ($episodenId, $characterId)
    {
        $charakter = new Story_Model_Charakter();
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', []);
        $select->joinInner('charakter', 'charakter.charakterId = episodenToCharakter.charakterId AND charakter.active = 1');
        $select->where('episodenToCharakter.charakterId = ?', $characterId);
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $row = $this->getDbTable('EpisodenCharakter')->fetchRow($select);
        if ($row !== null) {
            $charakter->setCharakterid($row['charakterId']);
            $charakter->setVorname($row['vorname']);
            $charakter->setNachname($row['nachname']);
        }
        return $charakter;
    }


    /**
     * @param $episodenId
     * @param $characterId
     *
     * @return Story_Model_CharakterResult
     * @throws Exception
     */
    public function getCharakterResult ($episodenId, $characterId)
    {
        $result = new Story_Model_CharakterResult();
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('episodenToCharakter', []);
        $select->joinInner(
            'episodenCharakterResult',
            'episodenCharakterResult.episodenId = episodenToCharakter.episodenId 
                    AND episodenCharakterResult.charakterId = episodenToCharakter.charakterId',
            [
                'gotKilled', 'npcsKilled', 'comment',
            ]
        );
        $select->where('episodenToCharakter.charakterId = ?', $characterId);
        $select->where('episodenToCharakter.episodenId = ?', $episodenId);
        $row = $this->getDbTable('EpisodenCharakter')->fetchRow($select);
        if ($row !== null) {
            $result = new Story_Model_CharakterResult();
            $result->setKillNpcs($row['npcsKilled']);
            $result->setDied($row['gotKilled']);
            $result->setComment($row['comment']);
        }
        return $result;
    }

    /**
     * @param int $episodenId
     * @param int $characterId
     *
     * @return array
     * @throws Exception
     */
    public function getRequestedCharakterKills ($episodenId, $characterId)
    {
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
        $stmt->execute([$episodenId, $characterId]);
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

    /**
     * @param Story_Model_EpisodenStatus $newStatus
     * @param int $episodenId
     *
     * @throws Exception
     */
    public function updateStatus (Story_Model_EpisodenStatus $newStatus, $episodenId)
    {
        $data = [
            'statusId' => $newStatus->getId(),
        ];
        $this->getDbTable('Episoden')->update($data, ['episodenId = ?' => $episodenId]);
    }

    /**
     * @param int $episodenId
     *
     * @throws Exception
     */
    public function initCharakterResult ($episodenId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO episodenCharakterResult (episodenId, charakterId) 
                                (SELECT episodenId, charakterId 
                                    FROM episodenToCharakter 
                                    WHERE episodenId = ?
                                )'
        );
        $stmt->execute([$episodenId]);
    }

    /**
     * @param int $episodenId
     * @param int $characterId
     * @param int $killcount
     *
     * @throws Exception
     */
    public function updateCharakterNpckills ($episodenId, $characterId, $killcount)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'UPDATE episodenCharakterResult
                                SET npcsKilled = ?
                                WHERE episodenId = ? AND charakterId = ?'
        );
        $stmt->execute([$killcount, $episodenId, $characterId]);
    }


    /**
     * @param $episodenId
     * @param $characterId
     * @param $comment
     *
     * @throws Exception
     */
    public function updateCharakterComment ($episodenId, $characterId, $comment)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'UPDATE episodenCharakterResult
                                SET comment = ?
                                WHERE episodenId = ? AND charakterId = ?'
        );
        $stmt->execute([$comment, $episodenId, $characterId]);
    }

    /**
     * @param int $episodenId
     * @param int $characterId
     * @param int $gotKilled
     *
     * @throws Exception
     */
    public function updateCharakterGotKilled ($episodenId, $characterId, $gotKilled)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'UPDATE episodenCharakterResult
                                SET gotKilled = ?
                                WHERE episodenId = ? AND charakterId = ?'
        );
        $stmt->execute([$gotKilled === 'true' ? 1 : 0, $episodenId, $characterId]);
    }


    /**
     * @param $episodenId
     * @param $characterId
     * @param array $ids
     *
     * @throws Exception
     */
    public function addCharakterKillRequests ($episodenId, $characterId, $ids = [])
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO episodenKillRequest (episodenId, charakterId, killedId)
                                VALUES (?, ?, ?)'
        );
        foreach ($ids as $id) {
            $stmt->execute([$episodenId, $characterId, $id]);
        }
    }


    /**
     * @param $episodenId
     * @param $characterId
     *
     * @throws Exception
     */
    public function removeCharakterKillRequests ($episodenId, $characterId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'DELETE FROM episodenKillRequest
                                WHERE episodenId = ? AND charakterId = ?'
        );
        $stmt->execute([$episodenId, $characterId]);
    }

    /**
     * @param int $newStatus
     * @param int $episodenId
     * @param int $characterId
     *
     * @throws Exception
     */
    public function updateCharakterStatus ($newStatus, $episodenId, $characterId)
    {
        $data = [
            'isReady' => $newStatus,
        ];
        $this->getDbTable('EpisodenCharakter')->update(
            $data, [
            'episodenId = ?' => $episodenId,
            'charakterId = ?' => $characterId,
        ]
        );
    }

    /**
     * @param int $episodenId
     *
     * @return boolean
     * @throws Exception
     */
    public function allReady ($episodenId)
    {
        $select = $this->getDbTable('EpisodenCharakter')->select();
        $select->where('episodenId = ? AND isReady = 0', $episodenId);
        return $this->getDbTable('EpisodenCharakter')->fetchAll($select)->count() === 0;
    }


    /**
     * @param $episodenId
     *
     * @throws Exception
     */
    public function deleteEpisode ($episodenId)
    {
        $this->getDbTable('Episoden')->delete(['episodenId = ?' => $episodenId]);
    }

    /**
     * @param int $episodeId
     *
     * @return Story_Model_Auswertung
     * @throws Exception
     */
    public function getRejection ($episodeId)
    {
        $auswertung = new Story_Model_Auswertung();
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'SELECT episodenRejection.reason, benutzerdaten.profilname 
                                FROM episodenRejection 
                                INNER JOIN benutzerdaten USING (userId)
                                WHERE episodenId = ? AND episodenRejection.isActive = 1'
        );
        $stmt->execute([$episodeId]);
        $result = $stmt->fetch();
        if ($result !== false) {
            $auswertung->setDescription($result['reason']);
            $auswertung->setProfilname($result['profilname']);
        }
        return $auswertung;
    }


    /**
     * @param $episodeId
     *
     * @throws Exception
     */
    public function resetRejection ($episodeId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare('UPDATE episodenRejection SET isActive = 0 WHERE episodenId = ?');
        $stmt->execute([$episodeId]);
    }


    /**
     * @param $episodeId
     *
     * @throws Exception
     */
    public function resetEvaluations ($episodeId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare('UPDATE episodenAuswertung SET isActive = 0 WHERE episodenId = ?');
        $stmt->execute([$episodeId]);
    }

}
