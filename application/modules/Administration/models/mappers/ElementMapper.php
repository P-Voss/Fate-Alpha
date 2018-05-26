<?php

class Administration_Model_Mapper_ElementMapper extends Application_Model_Mapper_ElementMapper {

    /**
     * @param Administration_Model_Element $element
     *
     * @return int
     * @throws Exception
     */
    public function createElement(Administration_Model_Element $element) {
        $data['name'] = $element->getBezeichnung();
        $data['beschreibung'] = $element->getBeschreibung();
        $data['charakterisierung'] = $element->getCharakterisierung();
        $data['kosten'] = $element->getKosten();
        $data['createDate'] = $element->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $element->getEditor();
        
        return parent::getDbTable('Element')->insert($data);
    }

    /**
     * @param int $elementId
     * @return \Administration_Model_Element
     * @throws Exception
     */
    public function getElementById($elementId) {
        $model = new Administration_Model_Element();
        $select = parent::getDbTable('Element')->select();
        $select->where('elementId = ?', $elementId);
        $row = parent::getDbTable('Element')->fetchRow($select);
        if($row !== null){
            $model->setId($row['elementId']);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setCharakterisierung($row['charakterisierung']);
            $model->setKosten($row['kosten']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Element $element
     * @return int
     * @throws Exception
     */
    public function updateElement(Administration_Model_Element $element) {
        $data['name'] = $element->getBezeichnung();
        $data['beschreibung'] = $element->getBeschreibung();
        $data['charakterisierung'] = $element->getCharakterisierung();
        $data['kosten'] = $element->getKosten();
        $data['editDate'] = $element->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $element->getEditor();
        
        return parent::getDbTable('Element')->update($data, array('elementId = ?' => $element->getId()));
    }

    
}
