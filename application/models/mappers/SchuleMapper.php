<?php

class Application_Model_Mapper_SchuleMapper
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
     * @return array
     * @throws Exception
     */
    public function getAllSchools ()
    {
        $returnArray = [];
        $select = $this->getDbTable('Schule')->select();
        $result = $this->getDbTable('Schule')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Application_Model_Schule();
            $model->setId($row->magieschuleId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setMagiOrganization($row->organization);
            $returnArray[] = $model;
        }
        return $returnArray;
    }

    /**
     * @param $id
     *
     * @return Application_Model_Schule
     * @throws Exception
     */
    public function getSchoolById ($id)
    {
        $row = $this->getDbTable('Schule')->fetchRow(['magieschuleId = ?', $id]);
        if ($row !== null) {
            $model = new Application_Model_Schule();
            $model->setId($row->magieschuleId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            return $model;
        } else {
            throw new Exception('school does not exist');
        }
    }

    /**
     * @param $id
     *
     * @return Application_Model_Schule
     * @throws Exception
     */
    public function getSchoolByMagieId ($id)
    {
        $select = $this->getDbTable('Schule')
            ->select()
            ->setIntegrityCheck(false)
            ->from('magieschulen')
            ->joinInner('magien', 'magien.magieschuleId = magieschulen.magieschuleId', [])
            ->where('magien.magieId = ?', $id);
        $row = $this->getDbTable('Schule')->fetchRow($select);
        if ($row !== null) {
            $model = new Application_Model_Schule();
            $model->setId($row->magieschuleId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            return $model;
        } else {
            throw new Exception('school does not exist');
        }
    }

    /**
     * @param int $characterId
     *
     * @return Application_Model_Schule[]
     * @throws Exception
     */
    public function getSchoolsByCharacter ($characterId)
    {
        $schools = [];
        $schoolIds = [];
        $select = $this->getDbTable('Schule')
            ->select()
            ->setIntegrityCheck(false)
            ->from('magieschulen')
            ->joinInner('magien', 'magien.magieschuleId = magieschulen.magieschuleId', [])
            ->joinInner('charakterMagien', 'charakterMagien.magieId = magien.magieId', [])
            ->where('charakterMagien.charakterId = ?', $characterId);
        $result = $this->getDbTable('Schule')->fetchAll($select);
        foreach ($result as $row) {
            if (in_array($row->magieschuleId, $schoolIds)) {
                continue;
            }
            $model = new Application_Model_Schule();
            $model->setId($row->magieschuleId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $schools[] = $model;
            $schoolIds[] = $row->magieschuleId;
        }
        return $schools;
    }

    /**
     * @param int $organizationId
     *
     * @return Application_Model_Schule[]
     * @throws Exception
     */
    public function getSchoolByOrganization ($organizationId)
    {
        $schools = [];
        $result = $this->getDbTable('Schule')->fetchAll(['organization = ?' => $organizationId]);
        foreach ($result as $row) {
            $model = new Application_Model_Schule();
            $model->setId($row->magieschuleId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $schools[] = $model;
        }
        return $schools;
    }

}
