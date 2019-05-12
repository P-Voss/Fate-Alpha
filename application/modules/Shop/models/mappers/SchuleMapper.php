<?php

class Shop_Model_Mapper_SchuleMapper extends Application_Model_Mapper_SchuleMapper
{

    /**
     * @return Shop_Model_Schule[]
     * @throws Exception
     */
    public function getAllSchools ()
    {
        $returnArray = [];
        $result = parent::getDbTable('Schule')->fetchAll();
        foreach ($result as $row) {
            $schule = new Shop_Model_Schule();
            $schule->setId($row->magieschuleId);
            $schule->setBeschreibung($row->beschreibung);
            $schule->setBezeichnung($row->name);
            $returnArray[] = $schule;
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     * @param int $magieschuleId
     *
     * @return bool
     * @return bool
     * @throws Exception
     */
    public function checkIfLearned ($charakterId, $magieschuleId)
    {
        $select = parent::getDbTable('CharakterSchule')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('CharakterSchule')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Shop_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirements ($magieschuleId)
    {
        $requirementList = new Shop_Model_Requirementlist();
        $select = parent::getDbTable('SchuleVoraussetzung')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('SchuleVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Shop_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Shop_Model_Schule|boolean
     * @throws Exception
     */
    public function getMagieschuleById ($magieschuleId)
    {
        $select = parent::getDbTable('Schule')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $row = parent::getDbTable('Schule')->fetchRow($select);
        if ($row !== null) {
            $magieschule = new Shop_Model_Schule();
            $magieschule->setId($row->magieschuleId);
            $magieschule->setBeschreibung($row->beschreibung);
            $magieschule->setBezeichnung($row->name);
            return $magieschule;
        }
        throw new Exception('School does not exist');
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Schule $magieschule
     *
     * @throws Exception
     */
    public function unlockMagieschuleForCharakter (Application_Model_Charakter $charakter, Shop_Model_Schule $magieschule)
    {
        $kostenfaktor = $this->getMagieschulenKostenFaktor($charakter->getCharakterid());
        $data['charakterId'] = $charakter->getCharakterid();
        $data['magieschuleId'] = $magieschule->getId();
        parent::getDbTable('CharakterSchule')->insert($data);
        if ($magieschule->getId() !== 17) {
            parent::getDbTable('CharakterWerte')
                ->getAdapter()
                ->query(
                    'UPDATE charakterWerte SET fp = fp - ? WHERE charakterId = ?', [
                    ($kostenfaktor * 50), $charakter->getCharakterid()]
                );
        }
    }

    /**
     * @param int $charakterId
     *
     * @return array
     * @throws Exception
     */
    public function getMagieschulenByCharakterId ($charakterId)
    {
        $returnArray = [];
        $select = parent::getDbTable('Schule')->select();
        $select->setIntegrityCheck(false);
        $select->from('magieschulen');
        $select->joinInner('charakterMagieschulen', 'magieschulen.magieschuleId = charakterMagieschulen.magieschuleId');
        $select->where('charakterMagieschulen.charakterId = ?', $charakterId);
        $result = parent::getDbTable('Schule')->fetchAll($select);
        foreach ($result as $row) {
            $magieschule = new Shop_Model_Schule();
            $magieschule->setId($row->magieschuleId);
            $magieschule->setBeschreibung($row->beschreibung);
            $magieschule->setBezeichnung($row->name);

            $returnArray[] = $magieschule;
        }
        return $returnArray;
    }

    /**
     *
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function getMagieschulenKostenFaktor ($charakterId)
    {
        $select = parent::getDbTable('Schule')->select();
        $select->setIntegrityCheck(false);
        $select->from('magieschulen');
        $select->joinInner('charakterMagieschulen', 'magieschulen.magieschuleId = charakterMagieschulen.magieschuleId');
        $select->where('charakterMagieschulen.charakterId = ? AND magieschulen.magieschuleId != 17', $charakterId);
        $result = parent::getDbTable('Schule')->fetchAll($select);
        return min([$result->count(), 3]);
    }

}
