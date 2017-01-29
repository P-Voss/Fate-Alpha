<?php

class Application_Model_Mapper_InformationMapper {

    /**
     * @param string $tablename
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable($tablename) {
        $className = 'Application_Model_DbTable_' . $tablename;
        if(!class_exists($className)){
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if(!$dbTable instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }
    
    /**
     * @param int $informationId
     * @return Application_Model_Information
     */
    public function getInformation($userId, $informationId) {
        $information = new Application_Model_Information();
        $sql = <<<SQL
SELECT * 
FROM
    (
        SELECT
            `benutzerInformationen`.informationId,
            `informationen`.`name`,
            `informationen`.`kategorie` 
        FROM
            `benutzerInformationen` 
            INNER JOIN
                `informationen` 
                ON informationen.infoId = benutzerInformationen.informationId 
        WHERE
            (
                benutzerInformationen.userId = ?
            )
        UNION
        SELECT
            `benutzerInformationen`.informationId,
            `informationen`.`name`,
            `informationen`.`kategorie` 
        FROM
            plots 
            INNER JOIN
                charakterPlots 
                ON charakterPlots.plotId = plots.plotId 
                AND freigabe = 1 
            INNER JOIN
                charakter 
                ON charakterPlots.charakterId = charakter.charakterId 
            INNER JOIN
                benutzerInformationen 
                ON charakter.userId = benutzerInformationen.userId 
            INNER JOIN
                informationen 
                ON informationen.infoId = benutzerInformationen.informationId 
        WHERE
            (
                plots.userId = ?
            )
    )
    AS infos 
INNER JOIN informationenTexte 
    ON informationenTexte.infoId = infos.informationId
WHERE infos.informationId = ?
ORDER BY
    `kategorie` ASC
SQL;
        $stmt = $this->getDbTable('UserInfos')->getDefaultAdapter()->prepare($sql);
        $stmt->execute([$userId, $userId, $informationId]);
        $row = $stmt->fetch();
        if($row !== false){
            $information->setInformationId($row['infoId']);
            $information->setName($row['name']);
            $information->setInhalt($row['inhalt']);
        }
        return $information;
    }
    
    
    public function getInformations() {
        $returnArray = array();
        $select = $this->getDbTable('Information')->select();
        $select->setIntegrityCheck(false);
        $select->from('informationen');
        $select->joinInner('informationenTexte', 'informationen.infoId = informationenTexte.infoId');
        $select->order('kategorie');
        $result = $this->getDbTable('Information')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $information = new Application_Model_Information();
                $information->setInformationId($row->infoId);
                $information->setName($row->name);
                $information->setKategorie($row->kategorie);
                $returnArray[] = $information;
            }
        }
        return $returnArray;
    }
    
    
    public function getInformationsByUserId($userId) {
        $returnArray = [];
        $sql = <<<SQL
SELECT * 
FROM
    (
        SELECT
            `benutzerInformationen`.informationId,
            `informationen`.`name`,
            `informationen`.`kategorie` 
        FROM
            `benutzerInformationen` 
            INNER JOIN
                `informationen` 
                ON informationen.infoId = benutzerInformationen.informationId 
        WHERE
            (
                benutzerInformationen.userId = ?
            )
        UNION
        SELECT
            `benutzerInformationen`.informationId,
            `informationen`.`name`,
            `informationen`.`kategorie` 
        FROM
            plots 
            INNER JOIN
                charakterPlots 
                ON charakterPlots.plotId = plots.plotId 
                AND freigabe = 1 
            INNER JOIN
                charakter 
                ON charakterPlots.charakterId = charakter.charakterId 
            INNER JOIN
                benutzerInformationen 
                ON charakter.userId = benutzerInformationen.userId 
            INNER JOIN
                informationen 
                ON informationen.infoId = benutzerInformationen.informationId 
        WHERE
            (
                plots.userId = ?
            )
    )
    AS infos 
ORDER BY
    `kategorie` ASC
SQL;
        $stmt = $this->getDbTable('UserInfos')->getDefaultAdapter()->prepare($sql);
        $stmt->execute([$userId, $userId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $information = new Application_Model_Information();
            $information->setInformationId($row['informationId']);
            $information->setName($row['name']);
            $information->setKategorie($row['kategorie']);
            $returnArray[] = $information;
        }
        return $returnArray;
    }
    
    /**
     * @param int $informationId
     * @return \Application_Model_Requirementlist
     */
    public function getRequirements($informationId) {
        $requirementList = new Application_Model_Requirementlist();
        $select = $this->getDbTable('InfoCharakterVoraussetzungen')->select();
        $select->where('infoId = ?', $informationId);
        $result = $this->getDbTable('InfoCharakterVoraussetzungen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $requirement = new Application_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
    
    public function truncateBenutzerinformationen() {
        $this->getDbTable('UserInfos')->getDefaultAdapter()->query('TRUNCATE benutzerInformationen');
    }
    
    
    public function saveBenutzerinformationen($informationZuo) {
        $sql = 'INSERT INTO benutzerInformationen (userId, informationId) VALUES (?, ?)';
        $stmt = $this->getDbTable('UserInfos')->getDefaultAdapter()->prepare($sql);
        foreach ($informationZuo as $userZuo) {
            $userId = $userZuo['userId'];
            foreach ($userZuo['informationIds'] as $informationId) {
                $stmt->execute([$userId, $informationId]);
            }
        }
    }
    
}
