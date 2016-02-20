<?php

class Application_Model_Mapper_PlotMapper {

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
     * @param Application_Model_Plot $plot
     * @return int
     */
    public function createPlot(Application_Model_Plot $plot) {
        $data = array(
            'name' => $plot->getName(),
            'beschreibung' => $plot->getBeschreibung(),
            'createDate' => $plot->getCreateDate('Y-m-d H:i:s'),
        );
        return $this->getDbTable('Plots')->insert($data);
    }
    
    /**
     * @param int $plotId
     * @param string $genres
     */
    public function setGenres($plotId, $genres = array()) {
        $data = array('plotId' => $plotId);
        foreach ($genres as $genre) {
            $data['genre'] = $genre;
            $this->getDbTable('PlotGenres')->insert($data);
        }
    }
    
}
