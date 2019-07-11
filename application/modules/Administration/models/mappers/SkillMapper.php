<?php

/**
 * Class Administration_Model_Mapper_SkillMapper
 */
class Administration_Model_Mapper_SkillMapper
{

    /**
     * @param $tablename
     *
     * @return Zend_Db_Table_Abstract
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
     * @return array
     * @throws Exception
     */
    public function getSkills ()
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->distinct();
        $select->order('skillartId');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Skill();
            $model->setId($row->skillId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setRang($row->rang);
            $model->setSkillArt($row->skillartId);
            $model->setDisziplin($row->disziplin);
            $model->setUebung($row->uebung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }


    /**
     * @param array $skillarten
     * @param array $gruppen
     * @param array $klassen
     *
     * @return array
     * @throws Exception
     */
    public function searchSkills ($skillarten = [], $gruppen = [], $klassen = [])
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->from('skills');

        if (count($skillarten) > 0) {
            $select->where('skillartId IN (?)', $skillarten);
        }
        if (count($gruppen) > 0) {
            $select->joinLeft(
                ['gruppen' => 'skillCharakterVoraussetzungen'],
                'gruppen.skillId = skills.skillId AND gruppen.art = "Gruppe"',
                []
            );
            $select->where('gruppen.voraussetzung IN (?)', $gruppen);
        }
        if (count($klassen) > 0) {
            $select->joinLeft(
                ['klassen' => 'skillCharakterVoraussetzungen'],
                'klassen.skillId = skills.skillId AND klassen.art = "Klasse"',
                []
            );
            $select->where('klassen.voraussetzung IN (?)', $klassen);
        }

        $select->order('skillartId');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Skill();
            $model->setId($row->skillId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setRang($row->rang);
            $model->setSkillArt($row->skillartId);
            $model->setDisziplin($row->disziplin);
            $model->setUebung($row->uebung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRpgSkills ()
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->distinct();
        $select->where('lernbedingung != "Standard"');
        $select->order('skillartId');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Skill();
            $model->setId($row->skillId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setRang($row->rang);
            $model->setSkillArt($row->skillartId);
            $model->setDisziplin($row->disziplin);
            $model->setUebung($row->uebung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @param $skillId
     *
     * @return Administration_Model_Skill
     * @throws Exception
     */
    public function getSkillById ($skillId)
    {
        $model = new Administration_Model_Skill();
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillId = ?', $skillId);
        $row = $this->getDbTable('Skill')->fetchRow($select);
        if ($row !== null) {
            $model->setId($skillId);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setDisziplin($row['disziplin']);
            $model->setUebung($row['uebung']);
            $model->setFp($row['fp']);
            $model->setRang($row['rang']);
            $model->setSkillArt($row['skillartId']);
            $model->setLernbedingung($row['lernbedingung']);
            $model->setReplacesSkillId($row['replacesSkillId']);
        }
        return $model;
    }


    /**
     * @param Administration_Model_Skill $skill
     *
     * @return mixed
     * @throws Exception
     */
    public function createSkill (Administration_Model_Skill $skill)
    {
        $data['name'] = $skill->getBezeichnung();
        $data['beschreibung'] = $skill->getBeschreibung();
        $data['fp'] = $skill->getFp();
        $data['skillartId'] = $skill->getSkillArt();
        $data['uebung'] = $skill->getUebung();
        $data['disziplin'] = $skill->getDisziplin();
        $data['rang'] = $skill->getRang();
        $data['lernbedingung'] = $skill->getLernbedingung();
        $data['createDate'] = $skill->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $skill->getCreator();
        $data['replacesSkillId'] = $skill->getReplacesSkillId();

        $id = $this->getDbTable('Skill')->insert($data);
        $skill->setId($id);
        $this->setRequirementsSkill($skill);
        return $id;
    }


    /**
     * @param Administration_Model_Skill $skill
     *
     * @return int
     * @throws Exception
     */
    public function updateSkill (Administration_Model_Skill $skill)
    {
        $data['name'] = $skill->getBezeichnung();
        $data['beschreibung'] = $skill->getBeschreibung();
        $data['fp'] = $skill->getFp();
        $data['skillartId'] = $skill->getSkillArt();
        $data['uebung'] = $skill->getUebung();
        $data['disziplin'] = $skill->getDisziplin();
        $data['rang'] = $skill->getRang();
        $data['lernbedingung'] = $skill->getLernbedingung();
        $data['editDate'] = $skill->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $skill->getEditor();
        $data['replacesSkillId'] = $skill->getReplacesSkillId();

        $this->deleteRequirementsSkill($skill);
        $this->setRequirementsSkill($skill);
        return $this->getDbTable('Skill')->update(
            $data, [
                     'skillId = ?' => $skill->getId(),
                 ]
        );
    }


    /**
     * @param Administration_Model_Skill $skill
     *
     * @throws Exception
     */
    public function setRequirementsSkill (Administration_Model_Skill $skill)
    {
        $data['skillId'] = $skill->getId();
        foreach ($skill->getRequirementList()->getRequirements() as $requirement) {
            if ($requirement->getRequiredValue() === '') {
                continue;
            }
            $data['art'] = $requirement->getArt();
            foreach (explode('|', $requirement->getRequiredValue()) as $value) {
                $data['voraussetzung'] = $value;
                $this->getDbTable('SkillVoraussetzung')->insert($data);
            }
        }
    }


    /**
     * @param Administration_Model_Skill $skill
     *
     * @throws Exception
     */
    public function deleteRequirementsSkill (Administration_Model_Skill $skill)
    {
        $this->getDbTable('SkillVoraussetzung')->delete(['skillId = ?' => $skill->getId()]);
    }

    /**
     * @param int $skillId
     *
     * @return \Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementsSkill ($skillId)
    {
        $requirementList = new Administration_Model_Requirementlist();
        $select = $this->getDbTable('SkillVoraussetzung')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('SkillVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Administration_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

    /**
     * @return array Administration_Model_Magie
     * @throws Exception
     */
    public function getMagien ()
    {
        $schuleMapper = new Administration_Model_Mapper_SchuleMapper();
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->distinct();
        $select->order('magieschuleId');
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Magie();
            $model->setId($row->magieId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setPrana($row->prana);
            $model->setRang($row->rang);
            $model->setStufe($row->stufe);
            $model->setSchule($schuleMapper->getSchuleById($row->magieschuleId));
            $model->setLernbedingung($row->lernbedingung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }


    /**
     * @param array $magieschulen
     * @param array $gruppen
     * @param array $klassen
     *
     * @return array
     * @throws Exception
     */
    public function searchMagien ($magieschulen = [], $gruppen = [], $klassen = [])
    {
        $schuleMapper = new Administration_Model_Mapper_SchuleMapper();
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->from('magien');

        if (count($magieschulen) > 0) {
            $select->where('magieschuleId IN (?)', $magieschulen);
        }
        if (count($gruppen) > 0) {
            $select->joinLeft(
                ['gruppen' => 'magieCharakterVoraussetzungen'],
                'gruppen.magieId = magien.magieId AND gruppen.art = "Gruppe"',
                []
            );
            $select->where('gruppen.voraussetzung IN (?)', $gruppen);
        }
        if (count($klassen) > 0) {
            $select->joinLeft(
                ['klassen' => 'magieCharakterVoraussetzungen'],
                'klassen.magieId = magien.magieId AND klassen.art = "Klasse"',
                []
            );
            $select->where('klassen.voraussetzung IN (?)', $klassen);
        }

        $select->order('magieschuleId');
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Magie();
            $model->setId($row->magieId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setPrana($row->prana);
            $model->setRang($row->rang);
            $model->setStufe($row->stufe);
            $model->setSchule($schuleMapper->getSchuleById($row->magieschuleId));
            $model->setLernbedingung($row->lernbedingung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @return array Administration_Model_Magie
     * @throws Exception
     */
    public function getRpgMagien ()
    {
        $schuleMapper = new Administration_Model_Mapper_SchuleMapper();
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->distinct();
        $select->where('lernbedingung != "Standard"');
        $select->order('magieschuleId');
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Administration_Model_Magie();
            $model->setId($row->magieId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setFp($row->fp);
            $model->setPrana($row->prana);
            $model->setRang($row->rang);
            $model->setStufe($row->stufe);
            $model->setSchule($schuleMapper->getSchuleById($row->magieschuleId));
            $model->setLernbedingung($row->lernbedingung);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @param int $magieId
     *
     * @return \Administration_Model_Magie
     * @throws Exception
     */
    public function getMagieById ($magieId)
    {
        $elementMapper = new Administration_Model_Mapper_ElementMapper();
        $model = new Administration_Model_Magie();
        $select = $this->getDbTable('Magie')->select();
        $select->where('magieId = ?', $magieId);
        $row = $this->getDbTable('Magie')->fetchRow($select);
        if ($row !== null) {
            $model->setId($magieId);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setFp($row['fp']);
            $model->setPrana($row['prana']);
            $model->setRang($row['rang']);
            $model->setStufe($row['stufe']);
            $model->setLernbedingung($row['lernbedingung']);
            $model->setMagieschuleId($row['magieschuleId']);
            $model->setElement($elementMapper->getElementById($row['element']));
        }
        return $model;
    }

    /**
     * @param Administration_Model_Magie $magie
     *
     * @return int
     * @throws Exception
     */
    public function createMagie (Administration_Model_Magie $magie)
    {
        $data['name'] = $magie->getBezeichnung();
        $data['beschreibung'] = $magie->getBeschreibung();
        $data['fp'] = $magie->getFp();
        $data['prana'] = $magie->getPrana();
        $data['rang'] = $magie->getRang();
        $data['element'] = $magie->getElement()->getId();
        $data['stufe'] = $magie->getStufe();
        $data['magieschuleId'] = $magie->getSchule()->getId();
        $data['gruppe'] = $magie->getGruppe();
        $data['lernbedingung'] = $magie->getLernbedingung();
        $data['createDate'] = $magie->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $magie->getCreator();

        return $this->getDbTable('Magie')->insert($data);
    }

    /**
     * @param Administration_Model_Magie $magie
     *
     * @return int
     * @throws Exception
     */
    public function updateMagie (Administration_Model_Magie $magie)
    {
        $data['name'] = $magie->getBezeichnung();
        $data['beschreibung'] = $magie->getBeschreibung();
        $data['fp'] = $magie->getFp();
        $data['prana'] = $magie->getPrana();
        $data['rang'] = $magie->getRang();
        $data['element'] = $magie->getElement()->getId();
        $data['stufe'] = $magie->getStufe();
        $data['magieschuleId'] = $magie->getSchule()->getId();
        $data['gruppe'] = $magie->getGruppe();
        $data['lernbedingung'] = $magie->getLernbedingung();
        $data['createDate'] = $magie->getEditDate('Y-m-d H:i:s');
        $data['creator'] = $magie->getEditor();

        return $this->getDbTable('Magie')->update(
            $data, [
                     'magieId = ?' => $magie->getId(),
                 ]
        );
    }

    /**
     * @param Administration_Model_Magie $magie
     *
     * @return int
     * @throws Exception
     */
    public function deleteDependencies (Administration_Model_Magie $magie)
    {
        return $this->getDbTable('MagieCharakterVoraussetzungen')->delete(
            [
                'magieId = ?' => $magie->getId(),
            ]
        );
    }

    /**
     * @param Administration_Model_Magie $magie
     *
     * @throws Exception
     */
    public function setDependencies (Administration_Model_Magie $magie)
    {
        $data['magieId'] = $magie->getId();
        foreach ($magie->getRequirementList()->getRequirements() as $requirement) {
            if ($requirement->getRequiredValue() === '') {
                continue;
            }
            $data['art'] = $requirement->getArt();
            foreach (explode(':', $requirement->getRequiredValue()) as $value) {
                $data['voraussetzung'] = $value;
                $this->getDbTable('MagieCharakterVoraussetzungen')->insert($data);
            }
        }
    }

    /**
     * @param int $magieId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementsMagie ($magieId)
    {
        $requirementList = new Administration_Model_Requirementlist();
        $select = $this->getDbTable('MagieCharakterVoraussetzungen')->select();
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('MagieCharakterVoraussetzungen')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Administration_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
