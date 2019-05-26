<?php

/**
 * Class Story_Model_Mapper_Result_AchievementMapper
 */
class Story_Model_Mapper_Result_AchievementMapper
{

    use Story_Model_Mapper_DbTableTrait;


    /**
     * @param Story_Model_Achievement $achievement
     *
     * @throws Exception
     */
    public function addAchievementRequest (Story_Model_Achievement $achievement)
    {
        try {
            $db = $this->getDbTable('Episoden')->getDefaultAdapter();
            $stmt = $db->prepare(
                'INSERT INTO episodenCharakterAchievementRequest (episodeId, characterId, title, description, requestType, achievementId)
                                VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute(
                [
                    $achievement->getEpisodeId(),
                    $achievement->getCharacterId(),
                    $achievement->getTitle(),
                    $achievement->getDescription(),
                    $achievement->getRequestType(),
                    $achievement->getId()
                ]
            );
        } catch (Exception $exception) {
            Zend_Debug::dump($exception);
            exit;
        }
    }

    /**
     * @param $episodeId
     * @param $characterId
     *
     * @throws Exception
     */
    public function resetRemovalRequests ($episodeId, $characterId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $db->query(
            'DELETE FROM episodenCharakterAchievementRequest WHERE characterId = ? AND episodeId = ? AND requestType = "remove"',
            [$characterId, $episodeId]
        );
    }

    /**
     * @param $episodeId
     * @param $charakterId
     * @param $requestId
     */
    public function removeAchievement ($episodeId, $charakterId, $requestId)
    {
        try {
            $db = $this->getDbTable('Episoden')->getDefaultAdapter();
            $db->query(
                'DELETE FROM episodenCharakterAchievementRequest WHERE id = ? AND characterId = ? AND episodeId = ?',
                [$requestId, $charakterId, $episodeId]
            );
        } catch (Exception $exception) {
            Zend_Debug::dump($exception);
            exit;
        }
    }

    /**
     * @param $episodenId
     * @param $characterId
     *
     * @return Story_Model_Achievement[]
     * @throws Exception
     */
    public function getRequestedAchievements ($episodenId, $characterId)
    {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT eCAR.*, charakterAchievements.title AS existingTitle 
                FROM episodenCharakterAchievementRequest AS eCAR
                LEFT JOIN charakterAchievements ON charakterAchievements.id = eCAR.achievementId
                WHERE eCAR.episodeId = ? AND eCAR.characterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $characterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $achievement = new Story_Model_Achievement(
                $row['characterId'],
                $row['episodeId'],
                $row['existingTitle'] !== null ? $row['existingTitle'] : $row['title'],
                $row['description'],
                $row['requestType']
            );
            $achievement->setId($row['id']);
            $achievement->setAchievementId($row['achievementId']);
            $returnArray[] = $achievement;
        }
        return $returnArray;
    }

}