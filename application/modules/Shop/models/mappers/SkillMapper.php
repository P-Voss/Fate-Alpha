<?php

class Shop_Model_Mapper_SkillMapper
{

    /**
     * @param string $tablename
     *
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename)
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param int $skillArtId
     *
     * @return array
     * @throws Exception
     */
    public function getSkillsBySkillArtId ($skillArtId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillartId = ?', $skillArtId);
        $select->order('name');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Shop_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $skill->setBeschreibung($row->beschreibung);
            $skill->setFp($row->fp);
            $skill->setRang($row->rang);
            $skill->setSkillArt($skillArtId);
            $skill->setRequirementList($this->getRequirements($row->skillId));
            $returnArray[] = $skill;
        }
        return $returnArray;
    }

    /**
     * @param int $skillArtId
     * @param $charakterId
     *
     * @return Shop_Model_Skill[]
     * @throws Exception
     */
    public function getLearnedSkillsBySkillArtId ($skillArtId, $charakterId)
    {
        $returnArray = [];
        $sql = <<<SQL
SELECT
    `skills`.* 
FROM
    `skills` 
    INNER JOIN
        `charakterSkills` 
        ON charakterSkills.skillId = skills.skillId 
WHERE
    skills.skillartId = ?
    AND charakterSkills.charakterId = ?
    AND skills.skillId NOT IN 
    (
    SELECT
        `skills`.replacesSkillId 
    FROM
        `skills` 
        INNER JOIN
            `charakterSkills` 
            ON charakterSkills.skillId = skills.skillId 
    WHERE
        skillartId = ?
        AND charakterSkills.charakterId = ?
        AND skills.replacesSkillId IS NOT NULL
    )
ORDER BY
    `name` ASC
SQL;
        $stmt = $this->getDbTable('Skill')->getDefaultAdapter()->prepare($sql);
        $stmt->execute([$skillArtId, $charakterId, $skillArtId, $charakterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $skill = new Shop_Model_Skill();
            $skill->setId($row['skillId']);
            $skill->setBezeichnung($row['name']);
            $skill->setBeschreibung($row['beschreibung']);
            $skill->setFp($row['fp']);
            $skill->setRang($row['rang']);
            $skill->setSkillArt($skillArtId);
            $skill->setRequirementList($this->getRequirements($row['skillId']));
            $returnArray[] = $skill;
        }
        return $returnArray;
    }


    /**
     * @param int $skillArtId
     *
     * @return Shop_Model_Skill[]
     * @throws Exception
     */
    public function getShopSkillsBySkillArtId ($skillArtId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillartId = ? and lernbedingung = "Standard"', $skillArtId);
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Shop_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $skill->setBeschreibung($row->beschreibung);
            $skill->setFp($row->fp);
            $skill->setSkillArt($skillArtId);
            $skill->setRequirementList($this->getRequirements($row->skillId));
            $returnArray[] = $skill;
        }
        return $returnArray;
    }

    /**
     * @param int $skillId
     *
     * @return Shop_Model_Skill
     * @throws Exception
     */
    public function getSkillById ($skillId)
    {
        $skill = new Shop_Model_Skill();
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('Skill')->fetchRow($select);
        if ($result !== null) {
            $row = $result->getIterator();
            $skill->setId($skillId);
            $skill->setBezeichnung($row['name']);
            $skill->setBeschreibung($row['beschreibung']);
            $skill->setSkillArt($row['skillartId']);
            $skill->setRequirementList($this->getRequirements($skillId));
            $skill->setRang($row['rang']);
            $skill->setFp($row['fp']);
            $skill->setLernbedingung($row['lernbedingung']);
        }
        return $skill;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Skill $skill
     *
     * @return int
     * @throws Exception
     */
    public function unlockSkill (Application_Model_Charakter $charakter, Shop_Model_Skill $skill)
    {
        $data = [
            'charakterId' => $charakter->getCharakterid(),
            'skillId' => $skill->getId(),
        ];
        $this->getDbTable('CharakterWerte')->getDefaultAdapter()
            ->query('UPDATE charakterWerte SET fp = fp - ' . $skill->getFp() . ' WHERE charakterId = ' . $charakter->getCharakterid());
        return $this->getDbTable('CharakterSkill')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $skillId
     *
     * @return int
     * @throws Exception
     */
    public function unlockSkillByRPG ($charakterId, $skillId)
    {
        $data = [
            'charakterId' => $charakterId,
            'skillId' => $skillId,
        ];
        return $this->getDbTable('CharakterSkill')->insert($data);
    }

    /**
     *
     * @param int $charakterId
     * @param int $skillId
     *
     * @return boolean
     * @throws Exception
     */
    public function checkIfLearned ($charakterId, $skillId)
    {
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $skillId
     *
     * @return \Shop_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirements ($skillId)
    {
        $requirementList = new Shop_Model_Requirementlist();
        $select = $this->getDbTable('SkillVoraussetzung')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('SkillVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Shop_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
