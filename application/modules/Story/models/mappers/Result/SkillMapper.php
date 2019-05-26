<?php

/**
 * Class Story_Model_Mapper_Result_SkillMapper
 */
class Story_Model_Mapper_Result_SkillMapper
{

    use Story_Model_Mapper_DbTableTrait;

    /**
     * @param int $charakterId
     *
     * @return Story_Model_Skill[]
     * @throws Exception
     */
    public function getSkillsToLearnByRpg ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->setIntegrityCheck(false);
        $select->from('skills');
        $select->joinLeft(
            'charakterSkills',
            'skills.skillId = charakterSkills.skillId AND charakterSkills.charakterId = ' . (int)$charakterId,
            []
        );
        $select->where('skills.lernbedingung = "RPG-Ereignis" AND charakterSkills.skillId IS NULL');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $returnArray[] = $skill;
        }
        return $returnArray;
    }


    /**
     * @param $episodenId
     * @param $charakterId
     * @param $art
     * @param $request
     *
     * @throws Exception
     */
    public function removeSkillrequest ($episodenId, $charakterId, $art, $request)
    {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare(
            'DELETE FROM episodenCharakterSkillRequest 
                                WHERE episodenId = ? 
                                AND charakterId = ? 
                                AND request = ? 
                                AND art = ?'
        );
        $stmt->execute([$episodenId, $charakterId, $request, $art]);
    }


    /**
     * @param $episodenId
     * @param $charakterId
     * @param $art
     * @param $request
     * @param array $ids
     *
     * @throws Exception
     */
    public function addSkillrequest ($episodenId, $charakterId, $art, $request, $ids = [])
    {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO episodenCharakterSkillRequest 
                                (episodenId, charakterId, art, id, request)
                                VALUES (?, ?, ?, ?, ?)'
        );
        foreach ($ids as $id) {
            $stmt->execute([$episodenId, $charakterId, $art, $id, $request]);
        }
    }


    /**
     * @param int $charakterId
     *
     * @return Application_Model_Skill[]
     * @throws Exception
     */
    public function getCharakterSkills ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterSkills', []);
        $select->joinInner(
            'skills',
            'charakterSkills.skillId = skills.skillId',
            ['skillId', 'name', 'beschreibung']
        );
        $select->where('charakterSkills.charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $skill->setBeschreibung($row->beschreibung);
            $returnArray[] = $skill;
        }
        return $returnArray;
    }

    /**
     *
     * @param int $episodenId
     * @param int $characterId
     *
     * @return array
     * @throws Exception
     */
    public function getRequestedSkills ($episodenId, $characterId)
    {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT skillId, name, request as requestType 
                FROM episodenCharakterSkillRequest AS eCSR
                INNER JOIN skills 
                    ON eCSR.art = "skill" 
                    AND eCSR.id = skills.skillId
                WHERE episodenId = ? AND charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodenId, $characterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row['skillId']);
            $skill->setBezeichnung($row['name']);
            $skill->setRequestType($row['requestType']);
            $returnArray[] = $skill;
        }
        return $returnArray;
    }

}