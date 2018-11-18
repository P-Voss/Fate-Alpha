<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Model_Mapper_ErstellungMapper extends Application_Model_Mapper_ErstellungMapper {


    /**
     * @return Application_Model_Klasse[]
     */
    public function getKlassen() {
        return parent::getAllClasses();
    }

    /**
     * @return Application_Model_Element[]
     */
    public function getElemente() {
        return parent::getAllElements();
    }
    
}
