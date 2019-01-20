<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_ErstellungMapper
{

    /**
     * @param $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename): Zend_Db_Table_Abstract
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
     * @param $classId
     * @return Erstellung_Model_Unterklasse[]
     */
    public function getSubclasses($classId): array
    {
        try {
            $select = $this->getDbTable('Klasse')->select()->where('klassengruppenId = ?', $classId);
            $result = $this->getDbTable('Klasse')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            $model = new Erstellung_Model_Unterklasse();
            $model->setId($row->klassenId);
            $model->setBezeichnung($row->klasse);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $model->setGruppe($row->klassengruppenId);
            $model->setFamilienname($row->familienname);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getAllClassgroups ()
    {
        $select = $this->getDbTable('Klassengruppe')->select();
        $result = $this->getDbTable('Klassengruppe')->fetchAll($select);
        if ($result->count() > 0) {
            $return = [];
            foreach ($result as $row) {
                $model = new Application_Model_Klassengruppe();
                $model->setId($row->klassengruppenId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $return[] = $model;
            }
            return $return;
        } else {
            return null;
        }
    }

    /**
     * @return Erstellung_Model_Circuit[]
     * @throws Exception
     */
    public function getAllCircuits ()
    {
        $return = [];
        $select = $this->getDbTable('Circuit')->select();
        $result = $this->getDbTable('Circuit')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Erstellung_Model_Circuit();
            $model->setId($row->circuitId);
            $model->setKategorie($row->kategorie);
            $model->setBeschreibung($row->besonderheit);
            $model->setMenge($row->menge);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @return Erstellung_Model_Luck[]
     * @throws Exception
     */
    public function getAllLuckvalues ()
    {
        $return = [];
        $select = $this->getDbTable('Luck')->select();
        $result = $this->getDbTable('Luck')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Erstellung_Model_Luck();
            $model->setId($row->luckId);
            $model->setKategorie($row->kategorie);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @return Erstellung_Model_Element[]
     */
    public function getAllElements (): array
    {
        try {
            $select = $this->getDbTable('Element')->select();
            $result = $this->getDbTable('Element')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            if (!in_array($row->elementId, [4,5,6,9])) {
                continue;
            }
            $model = new Erstellung_Model_Element();
            $model->setId($row->elementId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setCharakterisierung($row->charakterisierung);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @return Erstellung_Model_Odo[]
     * @throws Exception
     */
    public function getAllOdo ()
    {
        $return = [];
        $select = $this->getDbTable('Odo')->select();
        $result = $this->getDbTable('Odo')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Erstellung_Model_Odo();
            $model->setId($row->odoId);
            $model->setKategorie($row->kategorie);
            $model->setAmount($row->menge);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Erstellung_Model_Unterklasse[]
     * @throws Exception
     */
    public function getUnterklassenForCharakter (Application_Model_Charakter $charakter): array
    {
        $returnArray = [];
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->joinInner('klassen', 'charakter.klassengruppenId = klassen.klassengruppenId');
        $select->where('charakter.charakterId = ?', $charakter->getCharakterid());
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        foreach ($result as $row) {
            if ($row->maxCount > 0) {
                $select = $this->getDbTable('Charakter')->select();
                $select->from('charakter');
                $select->where('klassenId = ? and active = 1', $row->klassenId);
                $result = $this->getDbTable('Charakter')->fetchAll($select);
                if ($result->count() >= $row->maxCount) {
                    continue;
                }
            }
            $klasse = new Erstellung_Model_Unterklasse();
            $klasse->setId($row->klassenId);
            $klasse->setBezeichnung($row->klasse);
            $klasse->setBeschreibung($row->beschreibung);
            $klasse->setKosten($row->kosten);
            $klasse->setFamilienname($row->familienname);
            $returnArray[] = $klasse;
        }

        return $returnArray;
    }

    /**
     * @param int $unterklassenId
     *
     * @return Erstellung_Model_Requirementlist
     * @throws Exception
     */
    public function getUnterklassenRequirements ($unterklassenId): Erstellung_Model_Requirementlist
    {
        $requirementList = new Erstellung_Model_Requirementlist();
        $select = $this->getDbTable('KlasseVoraussetzung')->select();
        $select->where('unterklassenId = ?', $unterklassenId);
        $result = $this->getDbTable('KlasseVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Erstellung_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
