<?php

namespace Shop\Models\Mappers;

use Exception;
use Shop\Models\Requirement;
use Shop\Models\Requirementlist;
use Shop\Models\Schule;

/**
 * Class SchuleMapper
 * @package Shop\Models\Mappers
 */
class SchuleMapper extends \Application_Model_Mapper_SchuleMapper
{

    /**
     * @return Schule[]
     * @throws Exception
     */
    public function getAllSchools ()
    {
        $returnArray = [];
        $result = parent::getDbTable('Schule')->fetchAll();
        foreach ($result as $row) {
            $schule = new Schule();
            $schule->setId($row->magieschuleId);
            $schule->setBeschreibung($row->beschreibung);
            $schule->setBezeichnung($row->name);
            $schule->setMagiOrganization($row->organization);
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
     * @return Requirementlist
     * @throws Exception
     */
    public function getRequirements ($magieschuleId)
    {
        $requirementList = new Requirementlist();
        $select = parent::getDbTable('SchuleVoraussetzung')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('SchuleVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Schule
     * @throws Exception
     */
    public function getMagieschuleById ($magieschuleId)
    {
        $select = parent::getDbTable('Schule')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $row = parent::getDbTable('Schule')->fetchRow($select);
        if ($row !== null) {
            $magieschule = new Schule();
            $magieschule->setId($row->magieschuleId);
            $magieschule->setBeschreibung($row->beschreibung);
            $magieschule->setBezeichnung($row->name);
            $magieschule->setMagiOrganization($row->organization);
            return $magieschule;
        }
        throw new Exception('School does not exist');
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param Schule $magieschule
     *
     * @throws Exception
     */
    public function unlockMagieschuleForCharakter (\Application_Model_Charakter $charakter, Schule $magieschule, $cost)
    {
        $data['charakterId'] = $charakter->getCharakterid();
        $data['magieschuleId'] = $magieschule->getId();
        parent::getDbTable('Charakter')->update(
            ['magischoolId' => $magieschule->getId()],
            ['charakterId = ?' => $charakter->getCharakterid()]
        );
        parent::getDbTable('CharakterWerte')
            ->getAdapter()
            ->query(
                'UPDATE charakterWerte SET fp = fp - ? WHERE charakterId = ?',
                [$cost, $charakter->getCharakterid()]
            );
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
            $magieschule = new Schule();
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
