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
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO episodenCharakterAchievementRequest (episodeId, characterId, title, description, requestType)
                                VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute(
            [
                $achievement->getEpisodeId(),
                $achievement->getCharacterId(),
                $achievement->getTitle(),
                $achievement->getDescription(),
                $achievement->getRequestType()
            ]
        );
    }

    /**
     * @param $episodeId
     * @param $charakterId
     * @param int $achievementId
     *
     * @throws Exception
     */
    public function removeAchievement ($episodeId, $charakterId, $achievementId)
    {
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $stmt = $db->prepare(
            'DELETE FROM episodenCharakterAchievementRequest WHERE id = ? AND characterId = ? AND episodeId = ?'
        );
        $stmt->execute([$achievementId, $charakterId, $episodeId]);
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
        $sql = 'SELECT eCAR.* 
                FROM episodenCharakterAchievementRequest AS eCAR
                WHERE eCAR.episodeId = ? AND eCAR.characterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $characterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $achievement = new Story_Model_Achievement(
                $row['characterId'],
                $row['episodeId'],
                $row['title'],
                $row['description'],
                $row['id']
            );
            $returnArray[] = $achievement;
        }
        return $returnArray;
    }

}