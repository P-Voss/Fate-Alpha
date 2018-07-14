<?php

class Application_Model_Mapper_NewsMapper
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
    public function getNews ()
    {
        $return = [];
        $select = $this->getDbTable('News')->select();
        $select->setIntegrityCheck(false);
        $select->from('news');
        $select->order('newsId DESC');
        $select->limit(8);
        $result = $this->getDbTable('News')->fetchAll($select);

        $usermapper = new Application_Model_Mapper_UserMapper();
        foreach ($result as $row) {
            $model = new Application_Model_News();
            $model->setId($row->newsId);
            $model->setDatum($row->creationDate);
            $model->setEditdatum($row->editDate);
            $model->setEditor($row->editUserId);
            $model->setNachricht($row->nachricht);
            $model->setTitel($row->titel);
            $model->setVerfasser($row->verfasserUserId);
            $model->setVerfasserName($usermapper->getAdminnameById($row->verfasserUserId));
            if ((int)$row->editUserId > 0) {
                $model->setEditorName($usermapper->getAdminnameById($row->editUserId));
            }
            $return[] = $model;
        }
        return $return;
    }

}

