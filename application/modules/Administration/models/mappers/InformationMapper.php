<?php

class Administration_Model_Mapper_InformationMapper extends Application_Model_Mapper_InformationMapper
{

    /**
     * @return array
     */
    public function getAllInformations ()
    {
        try {
            $returnArray = [];
            $select = $this->getDbTable('Information')->select();
            $select->order('kategorie')->order('name');
            $result = $this->getDbTable('Information')->fetchAll($select);
            if ($result->count() > 0) {
                foreach ($result as $row) {
                    $model = new Application_Model_Information();
                    $model->setInformationId($row->infoId);
                    $model->setName($row->name);
                    $model->setKategorie($row->kategorie);
                    $returnArray[] = $model;
                }
            }
            return $returnArray;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param int $informationId
     *
     * @return \Administration_Model_Information
     * @throws Exception
     */
    public function getInformationById ($informationId)
    {
        $model = new Administration_Model_Information();
        $select = parent::getDbTable('Information')->select();
        $select->setIntegrityCheck(false);
        $select->from('informationen');
        $select->joinLeft('informationenTexte', 'informationen.infoId = informationenTexte.infoId', ['inhalt']);
        $select->where('informationen.infoId = ?', $informationId);
        $row = parent::getDbTable('Information')->fetchRow($select);
        if ($row !== null) {
            $model->setInformationId($row['infoId']);
            $model->setName($row['name']);
            $model->setKategorie($row->kategorie);
            $model->setInhalt($row['inhalt']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Information $information
     *
     * @return int
     * @throws Exception
     */
    public function createInformation (Administration_Model_Information $information)
    {
        $data['name'] = $information->getName();
        $data['createDate'] = $information->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $information->getCreator();
        $data['kategorie'] = $information->getKategorie();

        $id = parent::getDbTable('Information')->insert($data);
        $data = [
            'infoId' => $id,
            'inhalt' => $information->getInhalt(),
        ];
        parent::getDbTable('InformationText')->insert($data);
        return $id;
    }

    /**
     * @param Administration_Model_Information $information
     *
     * @return int
     * @throws Exception
     */
    public function updateInformation (Administration_Model_Information $information)
    {
        $data['name'] = $information->getName();
        $data['editDate'] = $information->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $information->getEditor();
        $data['kategorie'] = $information->getKategorie();

        parent::getDbTable('Information')->update($data, ['infoId = ?' => $information->getInformationId()]);
        $data = [
            'inhalt' => $information->getInhalt(),
        ];
        return parent::getDbTable('InformationText')->update($data, ['infoId = ?' => $information->getInformationId()]);
    }

    /**
     * @param Administration_Model_Information $information
     *
     * @throws Exception
     */
    public function setDependencies (Administration_Model_Information $information)
    {
        $data['infoId'] = $information->getInformationId();
        foreach ($information->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('InfoCharakterVoraussetzungen')->insert($data);
        }
    }

    /**
     * @param Administration_Model_Information $information
     *
     * @return int
     * @throws Exception
     */
    public function deleteDependencies (Administration_Model_Information $information)
    {
        return $this->getDbTable('InfoCharakterVoraussetzungen')->delete(
            [
                'infoId = ?' => $information->getInformationId(),
            ]
        );
    }

    /**
     * @param $characterId
     *
     * @return Administration_Model_Information[]
     */
    public function getCharacterInformation ($characterId)
    {
        try {
            $informations = [];
            $select = $this->getDbTable('Information')->select()
                ->setIntegrityCheck(false)
                ->from('informationen')
                ->joinInner('characterInformation', 'characterInformation.informationId = informationen.infoId', [])
                ->where('characterInformation.characterId = ?', $characterId);
            $result = $this->getDbTable('Information')->fetchAll($select);
            foreach ($result as $row) {
                $information = new Administration_Model_Information();
                $information->setInformationId($row['infoId']);
                $information->setName($row['name']);
                $information->setKategorie($row->kategorie);
                $informations[] = $information;
            }
            return $informations;
        } catch (Exception $exception) {
            return [];
        }
   }

    /**
     * @param $characterId
     *
     * @throws Exception
     */
    public function removeCharacterInformation ($characterId)
    {
        $this->getDbTable('CharacterInformation')->delete(['characterId = ?' => $characterId]);
   }

    /**
     * @param $informationId
     * @param $characterId
     *
     * @throws Exception
     */
    public function addCharacterInformation ($informationId, $characterId)
    {
        $data = [
            'characterId' => $characterId,
            'informationId' => $informationId
        ];
        $this->getDbTable('CharacterInformation')->insert($data);
   }

}
