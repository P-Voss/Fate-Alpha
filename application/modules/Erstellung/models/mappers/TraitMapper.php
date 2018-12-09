<?php

class Erstellung_Model_Mapper_TraitMapper extends Application_Model_Mapper_TraitMapper {

    /**
     * @return Application_Model_Trait[]
     */
    public function getAllTraits () : array
    {
        try {
            $select = $this->getDbTable('Traits')->select();
            $result = $this->getDbTable('Traits')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            $model = new Erstellung_Model_Trait();
            $model->setTraitId($row->traitId);
            $model->setName($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

}
