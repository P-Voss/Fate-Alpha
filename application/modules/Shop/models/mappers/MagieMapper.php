<?php

namespace Shop\Models\Mappers;

use \Exception;
use Shop\Models\Magie;
use Shop\Models\Requirement;
use Shop\Models\Requirementlist;

/**
 * Class MagieMapper
 * @package Shop\Models\Mappers
 */
class MagieMapper
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
        if (!$dbTable instanceof \Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Magie []
     * @throws Exception
     */
    public function getMagienByMagieschuleId ($magieschuleId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->setIntegrityCheck(false);
        $select->from('magien');
        $select->joinLeft(
            'elemente', 'magien.element = elemente.elementId', [
                          'elementId' => 'elemente.elementId', 'elementName' => 'elemente.name']
        );
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $magie = new Magie ();
            $magie->setBeschreibung($row->beschreibung);
            $magie->setBezeichnung($row->name);
            $magie->setId($row->magieId);
            $magie->setFp($row->fp);
            $magie->setPrana($row->prana);
            $element = new \Application_Model_Element();
            $element->setId($row->elementId);
            $element->setBezeichnung($row->elementName);
            $magie->setElement($element);
            $magie->setRang($row->rang);
            $magie->setGruppe($row->gruppe);
            $magie->setStufe($row->stufe);
            $magie->setLernbedingung($row->lernbedingung);

            $returnArray[] = $magie;
        }
        return $returnArray;
    }

    /**
     * @param int $magieschuleId
     *
     * @return Magie []
     * @throws Exception
     */
    public function getShopMagienByMagieschuleId ($magieschuleId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->setIntegrityCheck(false);
        $select->from('magien');
        $select->joinLeft(
            'elemente', 'magien.element = elemente.elementId', [
                          'elementId' => 'elemente.elementId', 'elementName' => 'elemente.name']
        );
        $select->where('magieschuleId = ? AND lernbedingung = "Standard"', $magieschuleId);
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $magie = new Magie ();
            $magie->setBeschreibung($row->beschreibung);
            $magie->setBezeichnung($row->name);
            $magie->setId($row->magieId);
            $magie->setFp($row->fp);
            $magie->setPrana($row->prana);
            $element = new \Application_Model_Element();
            $element->setId($row->elementId);
            $element->setBezeichnung($row->elementName);
            $magie->setElement($element);
            $magie->setRang($row->rang);
            $magie->setGruppe($row->gruppe);
            $magie->setStufe($row->stufe);
            $magie->setLernbedingung($row->lernbedingung);

            $returnArray[] = $magie;
        }
        return $returnArray;
    }

    /**
     * @param int $magieId
     *
     * @return Magie
     * @throws Exception
     */
    public function getMagieById ($magieId)
    {
        $magie = new Magie ();
        $select = $this->getDbTable('Magie')->select();
        $select->setIntegrityCheck(false);
        $select->from('magien');
        $select->joinLeft(
            'elemente', 'magien.element = elemente.elementId', [
                          'elementId' => 'elemente.elementId', 'elementName' => 'elemente.name']
        );
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('Magie')->fetchRow($select);
        if ($result !== null) {
            $row = $result->getIterator();
            $magie->setBeschreibung($row['beschreibung']);
            $magie->setBezeichnung($row['name']);
            $magie->setId($row['magieId']);
            $magie->setFp($row['fp']);
            $magie->setPrana($row['prana']);
            $element = new \Application_Model_Element();
            $element->setId($row['element']);
            $element->setBezeichnung($row['elementName']);
            $magie->setElement($element);
            $magie->setRang($row['rang']);
            //            $magie->setKlasse($this->getKlasse($row['klasse']));
            $magie->setStufe($row['stufe']);
            $magie->setLernbedingung($row['lernbedingung']);
        }
        return $magie;
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param Magie $magie
     *
     * @return int
     * @throws Exception
     */
    public function unlockMagie (\Application_Model_Charakter $charakter, Magie $magie)
    {
        $data = [
            'charakterId' => $charakter->getCharakterid(),
            'magieId' => $magie->getId(),
        ];
        $this->getDbTable('charakterWerte')->getDefaultAdapter()
            ->query('UPDATE charakterWerte SET fp = fp - ' . $magie->getFp() . ' WHERE charakterId = ' . $charakter->getCharakterid());
        return $this->getDbTable('charakterMagie')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $magieId
     *
     * @return int
     * @throws Exception
     */
    public function unlockMagieByRPG ($charakterId, $magieId)
    {
        $data = [
            'charakterId' => $charakterId,
            'magieId' => $magieId,
        ];
        return $this->getDbTable('charakterMagie')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $magieId
     *
     * @return int
     * @throws Exception
     */
    public function removeMagic ($charakterId, $magieId)
    {
        $data = [
            'charakterId = ?' => $charakterId,
            'magieId = ?' => $magieId,
        ];
        return $this->getDbTable('charakterMagie')->delete($data);
    }

    /**
     *
     * @param int $charakterId
     * @param int $magieId
     *
     * @return bool
     * @throws Exception
     */
    public function checkIfLearned ($charakterId, $magieId)
    {
        $select = $this->getDbTable('CharakterMagie')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('CharakterMagie')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $klassenId
     *
     * @return \Application_Model_Klasse
     * @throws Exception
     */
    public function getKlasse ($klassenId)
    {
        $klasse = new \Application_Model_Klasse();
        if ($klassenId === null) {
            return $klasse;
        }
        if ($klassenId !== null) {
            $select = $this->getDbTable('Klasse')->select();
            $select->where('klassenId = ?', $klassenId);
            $result = $this->getDbTable('Klasse')->fetchAll($select);
            if ($result->count() > 0) {
                $row = $result->current();
                $klasse->setId($row->klassenId);
                $klasse->setBezeichnung($row->klasse);
                $klasse->setBeschreibung($row->beschreibung);
                $klasse->setGruppe($this->getKlassengruppe($row->klassengruppenId));
            }
        }
        return $klasse;
    }

    /**
     * @param int $klassengruppenId
     *
     * @return \Application_Model_Klassengruppe
     * @throws Exception
     */
    private function getKlassengruppe ($klassengruppenId)
    {
        $klassengruppe = new \Application_Model_Klassengruppe();
        if ($klassengruppenId !== null) {
            $select = $this->getDbTable('Klassengruppe')->select();
            $select->where('klassengruppenId = ?', $klassengruppenId);
            $result = $this->getDbTable('Klasse')->fetchAll($select);
            if ($result->count() > 0) {
                $row = $result->current();
                $klassengruppe->setId($row->klassengruppenId);
                $klassengruppe->setBezeichnung($row->name);
                $klassengruppe->setBeschreibung($row->beschreibung);
            }
        }
        return $klassengruppe;
    }

    /**
     * @param int $magieId
     *
     * @return Requirementlist
     * @throws Exception
     */
    public function getRequirements ($magieId)
    {
        $requirementList = new Requirementlist();
        $select = $this->getDbTable('MagieCharakterVoraussetzungen')->select();
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('MagieCharakterVoraussetzungen')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
