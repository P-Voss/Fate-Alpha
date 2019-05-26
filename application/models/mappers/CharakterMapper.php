<?php

/**
 * Class Application_Model_Mapper_CharakterMapper
 */
class Application_Model_Mapper_CharakterMapper
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
     * @return Application_Model_Charakter[]
     * @throws Exception
     */
    public function getAllCharakters ()
    {
        try {
            $select = $this->getDbTable('Charakter')->select();
            $select->where('active = 1');
            $result = $this->getDbTable('Charakter')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $returnArray = [];
        foreach ($result as $row) {
            $charakter = new Application_Model_Charakter();
            $charakter->setVorname($row->vorname);
            $charakter->setNachname($row->nachname);
            $charakter->setCharakterid($row->charakterId);
            $charakter->setAugenfarbe($row->augenfarbe);
            $charakter->setGeburtsdatum($row->geburtsdatum);
            $charakter->setGeschlecht($row->geschlecht);
            $charakter->setSexualitaet($row->sexualitaet);
            $charakter->setMagiccircuit($row->circuit);
            $charakter->setNickname($row->nickname);
            $charakter->setSize($row->size);
            $charakter->setWohnort($row->wohnort);
            $date = new DateTime($row->createDate);
            $charakter->setCreatedate($date);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @throws Exception
     */
    public function deleteCharakter (Application_Model_Charakter $charakter)
    {
        $db = $this->getDbTable('Charakter')->update(
            ['active' => 0],
            ['charakterId = ?' => $charakter->getCharakterid()]
        );
    }

    /**
     * @param int $elementId
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterElement ($elementId, $charakterId)
    {
        $data = [];
        $data['charakterId'] = $charakterId;
        $data['elementId'] = $elementId;
        return $this->getDbTable('CharakterElement')->insert($data);
    }

    /**
     * @param $traitId
     * @param $characterId
     *
     * @return int
     * @throws Exception
     */
    public function addCharacterTrait ($traitId, $characterId)
    {
        $data = [
            'characterId' => $characterId,
            'traitId' => $traitId,
        ];
        return $this->getDbTable('CharacterTraits')->insert($data);
    }

    /**
     * @param int $nachteilId
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterNachteil ($nachteilId, $charakterId)
    {
        $data = [];
        $data['charakterId'] = $charakterId;
        $data['nachteilId'] = $nachteilId;
        return $this->getDbTable('CharakterNachteil')->insert($data);
    }

    /**
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterWerte ($charakterId)
    {
        $data = [];
        $data['charakterId'] = $charakterId;
        $data['staerke'] = 10;
        $data['agilitaet'] = 10;
        $data['ausdauer'] = 10;
        $data['disziplin'] = 10;
        $data['kontrolle'] = 10;
        $data['uebung'] = 10;
        $data['fp'] = 150;
        $data['startpunkte'] = 150;
        return $this->getDbTable('CharakterWerte')->insert($data);
    }

    /**
     * @param int $userId
     *
     * @return boolean|\Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterByUserId ($userId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['C' => 'charakter'], ['C.*']);
        $select->where('C.userId = ?', $userId);
        $select->where('active = 1');
        $select->joinLeft(['K' => 'klassen'], 'C.klassenId = K.klassenId', ['K.klassengruppenId']);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $model = new Application_Model_Charakter();
            $model->setCharakterid($row->charakterId);
            $model->setVorname($row->vorname);
            $model->setNachname($row->nachname);
            $model->setCharakterid($row->charakterId);
            $model->setAugenfarbe($row->augenfarbe);
            $model->setGeburtsdatum($row->geburtsdatum);
            $model->setGeschlecht($row->geschlecht);
            $model->setSexualitaet($row->sexualitaet);
            $model->setNickname($row->nickname);
            $model->setSize($row->size);
            $model->setWohnort($row->wohnort);
            $model->setLuck($row->luck);
            $date = new DateTime($row->createDate);
            $model->setCreatedate($date);
            $model->setUndead($row->undead === 1);
            if ($model->getUndead()) {
                $undeadDate = new DateTime($row->undeadDate);
                $model->setUndeadDate($undeadDate);
            }
            return $model;
        } else {
            throw new Exception('No Character');
        }
    }

    /**
     * @param int $userId
     *
     * @return int
     * @throws Exception
     */
    public function getCharakterIdByUserId ($userId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['C' => 'charakter'], ['C.*']);
        $select->where('C.userId = ? AND active = 1', $userId);
        $result = $this->getDbTable('Charakter')->fetchRow($select);
        if ($result === null) {
            throw new Exception('Character does not exist');
        }
        return $result->charakterId;
    }

    /**
     * @param int $charakterId
     *
     * @return array
     * @return array
     * @throws Exception
     */
    public function getCharakterElemente ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterElement')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakterElemente'], []);
        $select->joinInner('elemente', 'elemente.elementId = zuo.elementId', ['elementId', 'name', 'beschreibung']);
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterElement')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $element = new Application_Model_Element();
                $element->setId($row->elementId);
                $element->setBezeichnung($row->name);
                $element->setBeschreibung($row->beschreibung);
                $returnArray[] = $element;
            }
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return \Application_Model_Element
     * @throws Exception
     */
    public function getNaturelement ($charakterId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakter'], []);
        $select->joinInner('elemente', 'elemente.elementId = zuo.naturelement', ['elementId', 'name', 'beschreibung']);
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $element = new Application_Model_Element();
            $element->setId($row->elementId);
            $element->setBezeichnung($row->name);
            $element->setBeschreibung($row->beschreibung);
            return $element;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Modifier[] $modifiers
     *
     * @return Application_Model_Odo
     * @throws Exception
     */
    public function getOdo ($charakterId, $modifiers = [])
    {
        $modifier = 0;
        foreach ($modifiers as $mod) {
            if ($mod->getAttribute() === 'odo') {
                $modifier += $mod->getValue();
            }
        }
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakter'], []);
        $select->joinInner('odo', 'odo.odoId = zuo.odo + ' . $modifier * -1, ['odoId', 'kategorie', 'menge']);
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $odo = new Application_Model_Odo();
            $odo->setId($row->odoId);
            $odo->setKategorie($row->kategorie);
            $odo->setAmount($row->menge);
            if ($modifier !== 0) {
                $odo->setModified(true);
                $odo->setModification($modifier);
            }
            return $odo;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Modifier[] $modifiers
     *
     * @return Application_Model_Luck
     * @throws Exception
     */
    public function getLuck ($charakterId, $modifiers = [])
    {
        $modifier = 0;
        foreach ($modifiers as $mod) {
            if ($mod->getAttribute() === 'luck') {
                $modifier += $mod->getValue();
            }
        }
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakter'], []);
        $select->joinInner('luck', 'luck.luckId = zuo.luck + ' . $modifier * -1, ['luckId', 'kategorie']);
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $luck = new Application_Model_Luck();
            $luck->setId($row->luckId);
            $luck->setKategorie($row->kategorie);
            if ($modifier !== 0) {
                $luck->setModified(true);
                $luck->setModification($modifier);
            }
            return $luck;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Circuit
     * @throws Exception
     */
    public function getMagiccircuit ($charakterId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakter'], []);
        $select->joinInner(
            'circuit', 'circuit.circuitId = zuo.circuit', [
                         'circuitId', 'besonderheit', 'kategorie', 'menge']
        );
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $circuit = new Application_Model_Circuit();
            $circuit->setId($row->circuitId);
            $circuit->setKategorie($row->kategorie);
            $circuit->setBeschreibung($row->besonderheit);
            $circuit->setMenge($row->menge);
        } else {
            $circuit = new Application_Model_Circuit();
            $circuit->setKategorie('F');
            $circuit->setMenge(0);
        }
        return $circuit;
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Modifier[] $modifiers
     *
     * @return Application_Model_Vermoegen
     * @throws Exception
     */
    public function getVermoegen ($charakterId, $modifiers = [])
    {
        $modifier = 0;
        foreach ($modifiers as $mod) {
            if ($mod->getAttribute() === 'vermoegen') {
                $modifier += $mod->getValue();
            }
        }
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(['zuo' => 'charakter'], []);
        $select->joinInner(
            'vermoegen', 'vermoegen.vermoegenId = zuo.vermoegen + ' . $modifier, [
                           'vermoegenId', 'beschreibung', 'kategorie', 'menge']
        );
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $vermoegen = new Application_Model_Vermoegen();
            $vermoegen->setId($row->vermoegenId);
            $vermoegen->setBeschreibung($row->beschreibung);
            $vermoegen->setKategorie($row->kategorie);
            $vermoegen->setMenge($row->menge);
            if ($modifier !== 0) {
                $vermoegen->setModified(true);
                $vermoegen->setModification($modifier);
            }
            return $vermoegen;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $charakterId
     *
     * @return mixed
     * @throws Exception
     */
    public function createCharakterProfile ($charakterId)
    {
        $data['charakterId'] = $charakterId;
        $data['kennenlernCode'] = Application_Service_Utility::generateShortHash();
        $data['privatCode'] = Application_Service_Utility::generateShortHash();
        return $this->getDbTable('CharakterProfil')->insert($data);
    }

    /**
     * @param int $charakterId
     *
     * @return \Application_Model_Charakterprofil
     * @throws Exception
     */
    public function getCharakterProfil ($charakterId)
    {
        $model = new Application_Model_Charakterprofil();
        $select = $this->getDbTable('CharakterProfil')->select();
        $select->from('charakterProfil');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterProfil')->fetchAll($select);
        if ($result->count() > 0) {
            $row = $result->current();
            $model->setCharaktergeschichte($row->charaktergeschichte);
            $model->setProfilpic($row->profilpic);
            $model->setCharpic($row->charpic);
            $model->setPrivatdaten($row->privatDaten);
            $model->setSldaten($row->slDaten);
            $model->setKennenlerncode($row->kennenlernCode);
            $model->setPrivatcode($row->privatCode);
        }
        return $model;
    }

    /**
     * @param int $profilId
     * @param int $charakterId
     *
     * @return array
     * @throws Exception
     * @todo Datenfreigabe als Klasse
     *
     */
    public function getDatenfreigabe ($profilId, $charakterId)
    {
        $freigabe = ['public' => 0, 'privat' => 0];
        $select = $this->getDbTable('Beziehungen')->select();
        $select->from('beziehungen');
        $select->where('profilId = ?', $profilId);
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Beziehungen')->fetchRow($select);
        if ($result !== null) {
            $freigabe['public'] = $result->public;
            $freigabe['privat'] = $result->private;
        }
        return $freigabe;
    }

    /**
     * @param int $charakterId
     *
     * @return \Application_Model_Charakterwerte
     * @throws Exception
     */
    public function getCharakterwerte ($charakterId)
    {
        $select = $this->getDbTable('CharakterWerte')->select();
        $select->from('charakterWerte');
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('CharakterWerte')->fetchRow($select);
        if ($row !== null) {
            $model = new Application_Model_Charakterwerte();
            $model->setStaerke($row->staerke);
            $model->setAgilitaet($row->agilitaet);
            $model->setAusdauer($row->ausdauer);
            $model->setDisziplin($row->disziplin);
            $model->setKontrolle($row->kontrolle);
            $model->setUebung($row->uebung);
            $model->setFp($row->fp);
            $model->setStartpunkte($row->startpunkte);
            return $model;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $characterId
     *
     * @return Application_Model_Trait[]
     * @throws Exception
     */
    public function getTraitsByCharacterId ($characterId)
    {
        try {
            $select = $this->getDbTable('CharacterTraits')->select();
            $select->setIntegrityCheck(false);
            $select->from(['CT' => 'characterTraits'], ['CT.storyType', 'CT.story']);
            $select->joinInner(
                'traits',
                'traits.traitId = CT.traitId',
                ['traits.traitId', 'traits.name', 'traits.beschreibung']
            );
            $select->where('CT.characterId = ?', $characterId);
            $result = $this->getDbTable('CharacterTraits')->fetchAll($select);
        } catch (Throwable $throwable) {
            return [];
        }
        $returnArray = [];
        foreach ($result as $row) {
            $trait = new Application_Model_Trait();
            $trait->setTraitId($row->traitId);
            $trait->setName($row->name);
            $trait->setBeschreibung($row->beschreibung);
            $trait->setStoryType($row->storyType ?? 0);
            $trait->setStory($row->story ?? '');

            $returnArray[] = $trait;
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter[]
     * @throws Exception
     */
    public function getFriendlist ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Beziehungen')->select();
        $select->setIntegrityCheck(false);
        $select->from('beziehungen');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Beziehungen')->fetchAll($select);
        foreach ($result as $row) {
            $returnArray[] = $this->getCharakter($row->profilId);
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return \Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakter ($charakterId)
    {
        $model = new Application_Model_Charakter();
        $select = $this->getDbTable('Charakter')->select();
        $select->where('charakterId = ? AND active = 1', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            $model->setVorname($row->vorname);
            $model->setNachname($row->nachname);
            $model->setCharakterid($row->charakterId);
            $model->setSize($row->size);
            $model->setAugenfarbe($row->augenfarbe);
            $model->setGeburtsdatum($row->geburtsdatum);
            $model->setGeschlecht($row->geschlecht);
            $model->setSexualitaet($row->sexualitaet);
            $model->setNickname($row->nickname);
            $model->setWohnort($row->wohnort);
            $model->setKillCount($row->npcKills);
            $model->setMagiOrganization($row->magiOrganization);
            $model->setMagischoolId($row->magischoolId);
            $model->setKillCount($row->npcKills);
            $date = new DateTime($row->createDate);
            $model->setCreatedate($date);
            $model->setUndead($row->undead === 1);
            if ($model->getUndead()) {
                $undeadDate = new DateTime($row->undeadDate);
                $model->setUndeadDate($undeadDate);
            }
            return $model;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param int $charakterId
     * @param int $charakterIdToCheck
     *
     * @return boolean
     * @throws Exception
     */
    public function checkAssociation ($charakterId, $charakterIdToCheck)
    {
        $select = $this->getDbTable('Beziehungen')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('profilId = ?', $charakterIdToCheck);
        $row = $this->getDbTable('Beziehungen')->fetchRow($select);

        return $row !== null;
    }

    /**
     * @param array $profile
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function setAssociation (array $profile, $charakterId)
    {
        $data = [
            'charakterId' => $charakterId,
            'profilId' => $profile['charakterId'],
        ];
        if ($profile['type'] === 'public') {
            $data['public'] = 1;
        }
        if ($profile['type'] === 'private') {
            $data['private'] = 1;
        }
        $select = $this->getDbTable('Beziehungen')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('profilId = ?', $profile['charakterId']);
        $result = $this->getDbTable('Beziehungen')->fetchRow($select);
        if ($result !== null) {
            return $this->updateAssociation($data, $result['zuordnungId']);
        } else {
            return $this->createAssociation($data);
        }
    }

    /**
     * @param array $data
     * @param int $associateId
     *
     * @return int
     * @throws Exception
     */
    private function updateAssociation (array $data, $associateId)
    {
        return $this->getDbTable('Beziehungen')->update($data, ['zuordnungId =?' => $associateId]);
    }

    /**
     * @param $organizationId
     * @param $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function updateOrganization ($organizationId, $charakterId)
    {
        return $this->getDbTable('Charakter')->update(['magiOrganization' => $organizationId], ['charakterId = ?' => $charakterId]);
    }

    /**
     * @param array $data
     *
     * @return int
     * @throws Exception
     */
    private function createAssociation (array $data)
    {
        return $this->getDbTable('Beziehungen')->insert($data);
    }

    /**
     * @param string $profileCode
     * @param int $charakterId
     *
     * @return array|boolean
     * @throws Zend_Db_Select_Exception
     * @throws Exception
     */
    public function verifyProfilecode ($profileCode, $charakterId)
    {
        $selectPublic = $this->getDbTable('CharakterProfil')->select();
        $selectPublic->setIntegrityCheck(false);
        $selectPublic->from(['cp' => 'charakterProfil'], [new Zend_Db_Expr('"public" AS type'), 'charakterId']);
        $selectPublic->where('kennenlernCode = ?', $profileCode);
        $selectPublic->where('charakterId != ?', $charakterId);

        $selectPrivate = $this->getDbTable('CharakterProfil')->select();
        $selectPrivate->setIntegrityCheck(false);
        $selectPrivate->from(['cp' => 'charakterProfil'], [new Zend_Db_Expr('"private" AS type'), 'charakterId']);
        $selectPrivate->where('privatCode = ?', $profileCode);
        $selectPrivate->where('charakterId != ?', $charakterId);

        $select = $this->getDbTable('CharakterProfil')->select();
        $select->union([$selectPrivate, $selectPublic]);
        $result = $this->getDbTable('CharakterProfil')->fetchRow($select);
        if ($result !== null) {
            $return['charakterId'] = $result['charakterId'];
            $return['type'] = $result['type'];
            return $return;
        }
        return false;
    }

    /**
     * @param int $charakterId
     *
     * @return int
     * @throws Exception
     */
    public function setNewProfileCode ($charakterId)
    {
        $data = [
            'kennenlernCode' => Application_Service_Utility::generateShortHash(),
            'privatCode' => Application_Service_Utility::generateShortHash(),
        ];
        return $this->getDbTable('CharakterProfil')->update($data, ['charakterId = ?' => $charakterId]);
    }

    /**
     * @param int $charakterId
     *
     * @throws Exception
     */
    public function setInitalSkillarten ($charakterId)
    {
        $data = [
            'charakterId' => $charakterId,
            'skillartId' => 3,
        ];
        $this->getDbTable('CharakterSkillart')->insert($data);
        $data['skillartId'] = 4;
        $this->getDbTable('CharakterSkillart')->insert($data);
        $data['skillartId'] = 1;
        $this->getDbTable('CharakterSkillart')->insert($data);
        $data['skillartId'] = 2;
        $this->getDbTable('CharakterSkillart')->insert($data);
    }

    /**
     * @param int $charakterId
     *
     * @return \Application_Model_Klasse
     * @throws Exception
     */
    public function getCharakterKlasse ($charakterId)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter', []);
        $select->joinInner('klassen', 'charakter.klassenId = klassen.klassenId');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Charakter')->fetchAll($select)->current();
        if ($result !== null) {
            $klasse = new Application_Model_Klasse();
            $klasse->setBezeichnung($result['klasse']);
            $klasse->setBeschreibung($result['beschreibung']);
            $klasse->setId($result['klassenId']);
            $klasse->setKosten($result['kosten']);
            return $klasse;
        } else {
            throw new Exception('Klasse konnte nicht gefunden werden');
        }
    }

    /**
     * @param int $charakterId
     * @param int $schuleId
     *
     * @return int
     * @throws Exception
     */
    public function getCharakterMagieStufe ($charakterId, $schuleId)
    {
        $select = $this->getDbTable('CharakterSchule')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('magieschuleId = ?', $schuleId);
        $result = $this->getDbTable('CharakterSchule')->fetchAll($select);
        switch ($result->count()) {
            case 0:
                $rang = 1;
                break;
            case 1:
                $rang = 2;
                break;
            case 2:
                $rang = 3;
                break;
            default:
                $rang = 4;
                break;
        }
        return $rang;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Schule[]
     * @throws Exception
     */
    public function getCharakterMagieschulen ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterSchule')->select();
        $select->setIntegrityCheck(false);
        $select->distinct();
        $select->from('charakterMagieschulen', ['magieschuleId']);
        $select->joinInner(
            'magieschulen',
            'charakterMagieschulen.magieschuleId = magieschulen.magieschuleId',
            ['name', 'beschreibung']
        );
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterSchule')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $magieschule = new Application_Model_Schule();
                $magieschule->setId($row->magieschuleId);
                $magieschule->setBezeichnung($row->name);
                $magieschule->setBeschreibung($row->beschreibung);
                $returnArray[] = $magieschule;
            }
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Skill[]
     * @throws Exception
     */
    public function getCharakterSkills ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterSkills', []);
        $select->joinInner(
            'skills',
            'charakterSkills.skillId = skills.skillId',
            ['skillId', 'name', 'beschreibung']
        );
        $select->where('charakterSkills.charakterId = ?', $charakterId);
        $select->order('skills.name');
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $skill = new Application_Model_Skill();
                $skill->setId($row->skillId);
                $skill->setBezeichnung($row->name);
                $skill->setBeschreibung($row->beschreibung);
                $returnArray[] = $skill;
            }
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Magie[]
     * @throws Exception
     */
    public function getCharakterMagien ($charakterId)
    {
        $schuleMapper = new Application_Model_Mapper_SchuleMapper();
        $returnArray = [];
        $select = $this->getDbTable('CharakterMagie')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterMagien', []);
        $select->joinInner(
            'magien',
            'charakterMagien.magieId = magien.magieId',
            ['magieId', 'name', 'beschreibung', 'rang', 'element', 'stufe']
        );
        $select->where('charakterMagien.charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterMagie')->fetchAll($select);
        foreach ($result as $row) {
            $magie = new Application_Model_Magie();
            $magie->setId($row->magieId);
            $magie->setBezeichnung($row->name);
            $magie->setBeschreibung($row->beschreibung);
            $magie->setRang($row->rang);
            $magie->setStufe($row->stufe);
            $magie->setSchule($schuleMapper->getSchoolByMagieId($magie->getId()));
            $returnArray[] = $magie;
        }
        return $returnArray;
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     */
    public function getCharacterItems ($characterId)
    {
        $returnArray = [];
        try {
            $select = $this->getDbTable('Item')
                ->select()
                ->setIntegrityCheck(false)
                ->from('charakterItems', [])
                ->joinInner('items', 'items.itemId = charakterItems.itemId')
                ->where('charakterItems.charakterId = ?', $characterId);
            $result = $this->getDbTable('Item')->fetchAll($select);
            foreach ($result as $row) {
                $item = new Application_Model_Item();
                $item->setId($row->itemId)
                    ->setName($row->name)
                    ->setType($row->type)
                    ->setRank($row->rank)
                    ->setDescription($row->description)
                    ->setCost($row->cost);
                $returnArray[] = $item;
            }
            return $returnArray;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param int $charakterId
     * @param string $picUrl
     *
     * @throws Exception
     */
    public function saveCharakterpic ($charakterId, $picUrl)
    {
        $data = ['charpic' => $picUrl];
        $this->getDbTable('CharakterProfil')->update($data, ['charakterId = ?' => $charakterId]);
    }

    /**
     * @param int $charakterId
     * @param string $picUrl
     *
     * @throws Exception
     */
    public function saveProfilpic ($charakterId, $picUrl)
    {
        $data = ['profilpic' => $picUrl];
        $this->getDbTable('CharakterProfil')->update($data, ['charakterId = ?' => $charakterId]);
    }

    /**
     *
     * @param Application_Model_Skill[] $skills
     *
     * @return \Application_Model_Modifier[]
     * @throws Exception
     */
    public function getModifierSkills ($skills = [])
    {
        $returnArray = [];
        $select = $this->getDbTable('SkillEigenschaften')->select();
        $select->where('1 = 2');
        foreach ($skills as $skill) {
            $select->orWhere('skillId = ?', $skill->getId());
        }
        $result = $this->getDbTable('SkillEigenschaften')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $modifier = new Application_Model_Modifier();
                $modifier->setAttribute($row->eigenschaft);
                $modifier->setValue($row->effekt);
                $returnArray[] = $modifier;
            }
        }
        return $returnArray;
    }

    /**
     *
     * @param int $charakterId
     *
     * @return Application_Model_Modifier[]
     */
    public function getModifierByCharakter ($charakterId)
    {
        $returnArray = [];
        $sql = <<<SQL
    SELECT * FROM (
        SELECT skillToEigenschaft.*, charakterId 
            FROM charakterSkills 
            INNER JOIN skillToEigenschaft 
                USING (skillId)
        UNION 
            SELECT effectId, traitId, traitToAttribute.attribute as eigenschaft, traitToAttribute.value as effekt, '' as effektart, characterId AS charakterId 
                FROM characterTraits 
                INNER JOIN traitToAttribute 
                    USING (traitId)
        UNION 
            SELECT klasseToEigenschaft.*, charakterId 
                FROM charakter 
                INNER JOIN klasseToEigenschaft 
                    USING (klassenId)
        ) AS modifications
    WHERE charakterId = ?
SQL;

        try {
            $db = $this->getDbTable('charakter')->getDefaultAdapter();
            $result = $db->query($sql, [$charakterId])->fetchAll();
            foreach ($result as $row) {
                $modifier = new Application_Model_Modifier();
                $modifier->setAttribute($row['eigenschaft']);
                $modifier->setValue($row['effekt']);
                $returnArray[] = $modifier;
            }
            return $returnArray;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return int
     * @throws Exception
     */
    public function editCharakter (Application_Model_Charakter $charakter)
    {
        $data = [
            'vorname' => $charakter->getVorname(),
            'nachname' => $charakter->getNachname(),
            'nickname' => $charakter->getNickname(),
            'augenfarbe' => $charakter->getAugenfarbe(),
            'geburtsdatum' => $charakter->getGeburtsdatum(),
            'geschlecht' => $charakter->getGeschlecht(),
            'sexualitaet' => $charakter->getSexualitaet(),
            'size' => $charakter->getSize(),
            'odo' => $charakter->getOdo()->getId(),
            'naturelement' => $charakter->getNaturElement()->getId(),
            'luck' => $charakter->getLuck()->getId(),
        ];
        return $this->getDbTable('Charakter')->update($data, ['charakterId = ?' => $charakter->getCharakterid()]);
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return int
     * @throws Exception
     */
    public function editCharakterWerte (Application_Model_Charakter $charakter)
    {
        $data = [
            'staerke' => $charakter->getCharakterwerte()->getStaerke(),
            'agilitaet' => $charakter->getCharakterwerte()->getAgilitaet(),
            'ausdauer' => $charakter->getCharakterwerte()->getAusdauer(),
            'kontrolle' => $charakter->getCharakterwerte()->getKontrolle(),
            'disziplin' => $charakter->getCharakterwerte()->getDisziplin(),
            'uebung' => $charakter->getCharakterwerte()->getUebung(),
            'fp' => $charakter->getCharakterwerte()->getFp(),
            'startpunkte' => $charakter->getCharakterwerte()->getStartpunkte(),
        ];
        return $this->getDbTable('CharakterWerte')->update($data, ['charakterId = ?' => $charakter->getCharakterid()]);
    }

    /**
     * @return Application_Model_Charakter[]
     * @throws Zend_Db_Statement_Exception
     * @throws Exception
     */
    public function getCharaktersOrderedByNextBirthday ()
    {
        $returnArray = [];
        $sql = 'SELECT
                    *,
                    geburtsdatum + INTERVAL(YEAR(CURRENT_TIMESTAMP) - YEAR(geburtsdatum)) + 0 YEAR AS currbirthday,
                    geburtsdatum + INTERVAL(YEAR(CURRENT_TIMESTAMP) - YEAR(geburtsdatum)) + 1 YEAR AS nextbirthday
                FROM charakter
                WHERE active = 1 
                ORDER BY CASE
                    WHEN currbirthday >= CURRENT_TIMESTAMP THEN currbirthday
                    ELSE nextbirthday
                END';
        $result = $this->getDbTable('Charakter')->getDefaultAdapter()->query($sql)->fetchAll();
        if (count($result) > 0) {
            foreach ($result as $row) {
                $charakter = new Application_Model_Charakter();
                $charakter->setVorname($row['vorname']);
                $charakter->setNachname($row['nachname']);
                $charakter->setCharakterid($row['charakterId']);
                $charakter->setAugenfarbe($row['augenfarbe']);
                $charakter->setGeburtsdatum($row['geburtsdatum']);
                $charakter->setGeschlecht($row['geschlecht']);
                $charakter->setSexualitaet($row['sexualitaet']);
                $charakter->setMagiccircuit($row['circuit']);
                $charakter->setNickname($row['nickname']);
                $charakter->setSize($row['size']);
                $charakter->setWohnort($row['wohnort']);
                $date = new DateTime($row['createDate']);
                $charakter->setCreatedate($date);
                $returnArray[] = $charakter;
            }
        }
        return $returnArray;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Achievement[]
     * @throws Exception
     * @todo dbTable
     */
    public function getAchievements ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterAchievements');
        $select->where('charakterId = ? AND isActive = 1', $charakterId);
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        foreach ($result as $row) {
            $achievement = new Application_Model_Achievement();
            $achievement->setId($row['id']);
            $achievement->setTitle($row['title']);
            $achievement->setDescription($row['description']);
            $returnArray[] = $achievement;
        }
        return $returnArray;
    }


    /**
     * @param $charakterId
     * @param $killedId
     * @param null $episodeId
     *
     * @throws Exception
     */
    public function setCharakterKill ($charakterId, $killedId, $episodeId = null)
    {
        $data = [
            'charakterId' => $charakterId,
            'charakterKilledId' => $killedId,
            'episodeId' => $episodeId,
        ];
        $this->getDbTable('CharakterKills')->insert($data);
    }

    /**
     * @param $charakterId
     *
     * @throws Exception
     */
    public function deactivateCharakter ($charakterId)
    {
        $dateTime = new DateTime();
        $data = [
            'active' => 0,
            'deadDate' => $dateTime->format('Y-m-d'),
        ];
        $this->getDbTable('Charakter')->update($data, ['charakterId = ?' => $charakterId]);
    }


    /**
     * @param $charakterId
     * @param int $npcKills
     *
     * @throws Exception
     */
    public function updateNpcKills ($charakterId, $npcKills = 0)
    {
        $this->getDbTable('Charakter')
            ->getDefaultAdapter()
            ->query(
                'UPDATE charakter SET npcKills = npcKills + ' . (int)$npcKills . ' WHERE charakterId = ?', [$charakterId]
            );
    }


    /**
     * @param $charakterId
     *
     * @throws Exception
     */
    public function setUndead ($charakterId)
    {
        $dateTime = new DateTime();
        $data = [
            'undead' => 1,
            'undeadDate' => $dateTime->format('Y-m-d'),
        ];
        $this->getDbTable('Charakter')->update($data, ['charakterId = ?' => $charakterId]);
    }


    /**
     * @param $charakterId
     * @param $traitId
     *
     * @throws Exception
     */
    public function removeTrait ($charakterId, $traitId)
    {
        $this->getDbTable('CharakterTrait')
            ->delete(
                [
                    'charakterId = ?' => $charakterId,
                    'traitId = ?' => $traitId,
                ]
            );
    }

    /**
     * @param string $accessKey
     *
     * @return string
     * @throws Exception
     */
    public function getCharakterIdByAccessKey ($accessKey)
    {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false)
            ->from(['user' => 'benutzerdaten'], [])
            ->joinInner('charakter', 'charakter.userId = user.userId', ['charakter.charakterId'])
            ->where('user.accessKey = ? AND charakter.active = 1', $accessKey);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if ($row !== null) {
            return $row->charakterId;
        } else {
            throw new Exception('Keinen Charakter gefunden');
        }
    }

    /**
     * @param Application_Model_Trait $trait
     * @param $characterId
     *
     * @throws Exception
     */
    public function updateTraitStory (Application_Model_Trait $trait, $characterId)
    {
        try {
            $this->getDbTable('CharakterTrait')->update(
                ['story' => $trait->getStory(), 'storyType' => $trait->getStoryType()],
                ['characterId = ?' => $characterId, 'traitId = ?' => $trait->getTraitId()]
            );
        } catch (Throwable $exception) {
            Zend_Debug::dump($exception);
            exit;
        }
    }

    /**
     * @param Application_Model_Achievement $achievement
     * @param int $characterId
     *
     * @return int
     * @throws Exception
     */
    public function addAchievement (Application_Model_Achievement $achievement, $characterId)
    {
        $data = [
            'charakterId' => $characterId,
            'title' => $achievement->getTitle(),
            'description' => $achievement->getDescription(),
            'episodeId' => $achievement->getEpisodeId()
        ];
        return $this->getDbTable('CharakterAchievement')->insert($data);
    }

    /**
     * @param int $achievementId
     *
     * @throws Exception
     */
    public function deleteAchievement ($achievementId)
    {
        $this->getDbTable('CharakterAchievement')->update(['isActive' => 0], ['id = ?' => $achievementId]);
    }

}
