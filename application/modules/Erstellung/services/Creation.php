<?php

/**
 * Description of Erstellung_Service_Creation
 *
 * @author Voß
 */
class Erstellung_Service_Creation {

    /**
     * @var Erstellung_Model_Mapper_CharakterMapper
     */
    private $characterMapper;

    public function __construct ()
    {
        $this->characterMapper = new Erstellung_Model_Mapper_CharakterMapper();
    }


    /**
     * @param Erstellung_Model_Character $character
     *
     * @return int
     */
    public function saveCharacter (Erstellung_Model_Character $character)
    {
        try {
            $characterId = $this->characterMapper->createCharakter($character);
            $this->characterMapper->setInitalSkillarten($characterId);

            $this->characterMapper->saveCharakterWerte($characterId);
            $this->characterMapper->createCharakterProfile($characterId);
            foreach ($character->getTraits() as $trait) {
                $this->characterMapper->addTrait($characterId, $trait->getTraitId());
            }
            return $characterId;
        } catch (Exception $exception) {
            Zend_Debug::dump($exception);
            exit;
        }
    }

}
