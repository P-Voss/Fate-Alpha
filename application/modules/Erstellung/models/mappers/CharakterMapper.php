<?php

class Erstellung_Model_Mapper_CharakterMapper extends Application_Model_Mapper_CharakterMapper
{

    /**
     * @param Erstellung_Model_Character $charakter
     *
     * @return int
     * @throws Exception
     */
    public function createCharakter (Erstellung_Model_Character $charakter)
    {
        $date = new DateTime();
        $data = [];
        $data['userId'] = Zend_Auth::getInstance()->getIdentity()->userId;
        $data['uuid'] = $this->gen_uuid();
        $data['vorname'] = $charakter->getVorname();
        $data['nachname'] = $charakter->getNachname();
        $data['geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['augenfarbe'] = $charakter->getAugenfarbe();
        $data['size'] = $charakter->getSize();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['sexualitaet'] = $charakter->getSexualitaet();
        $data['wohnort'] = $charakter->getWohnort();

        $data['klassengruppenId'] = $charakter->getKlassengruppe()->getId();
        $data['klassenId'] = $charakter->getKlasse()->getId();
        $data['naturelement'] = $charakter->getNaturElement()->getId();
        $data['odo'] = $charakter->getOdo()->getId();
        $data['circuit'] = $charakter->getMagiccircuit()->getId();
        $data['luck'] = $charakter->getLuck()->getId();

        $data['createDate'] = $date->format('Y-m-d H:i:s');
        $data['active'] = 1;
        return parent::getDbTable('Charakter')->insert($data);
    }

    /**
     * @return string
     * @source https://stackoverflow.com/a/2040279
     */
    private function gen_uuid ()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * @param $userId
     *
     * @return bool|Erstellung_Model_Character
     * @throws Exception
     */
    public function getInactiveCharakterByUserId ($userId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['C' => 'charakter'], ['C.*']);
        $select->where('C.userId = ?', $userId);
        $select->where('C.active = 0');
        $select->joinLeft(['K' => 'klassen'], 'C.klassenId = K.klassenId', ['K.klassengruppenId']);
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $model = new Erstellung_Model_Character();
                $model->setVorname($row->vorname);
                $model->setNachname($row->nachname);
                $model->setCharakterid($row->charakterId);
                $model->setAugenfarbe($row->augenfarbe);
                $model->setGeburtsdatum($row->geburtsdatum);
                $model->setGeschlecht($row->geschlecht);
                $model->setSexualitaet($row->sexualitaet);
                $model->setMagiccircuit($row->circuit);
                $model->setNickname($row->nickname);
                $model->setSize($row->size);
                $model->setWohnort($row->wohnort);
                $date = new DateTime($row->createDate);
                $model->setCreatedate($date);
            }
            return $model;
        } else {
            return false;
        }
    }

    /**
     * @param Erstellung_Model_Character $charakter
     *
     * @return int
     * @throws Exception
     */
    public function updateCharakter (Erstellung_Model_Character $charakter)
    {
        $data = [];
        $data['vorname'] = $charakter->getVorname();
        $data['nachname'] = $charakter->getNachname();
        $data['geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['augenfarbe'] = $charakter->getAugenfarbe();
        $data['size'] = $charakter->getSize();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['sexualitaet'] = $charakter->getSexualitaet();
        $data['wohnort'] = $charakter->getWohnort();
        return parent::getDbTable('Charakter')->update($data, ['charakterId = ?' => $charakter->getCharakterid()]);
    }

    /**
     * @param $characterId
     * @param $traitId
     *
     * @return mixed
     * @throws Exception
     */
    public function addTrait ($characterId, $traitId)
    {
        $data = [
            'characterId' => $characterId,
            'traitId' => $traitId,
        ];
        return parent::getDbTable('CharakterTrait')->insert($data);
    }

}
