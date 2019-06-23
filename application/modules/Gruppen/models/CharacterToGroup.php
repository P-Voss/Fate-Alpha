<?php

/**
 * Description of Gruppe
 *
 * @author Voß
 */
class Gruppen_Model_CharacterToGroup
{

    public $characterId;
    public $groupId;

    /**
     * CharacterToGroup constructor.
     *
     * @param $characterId
     * @param $groupId
     */
    public function __construct ($characterId, $groupId)
    {
        $this->characterId = $characterId;
        $this->groupId = $groupId;
    }

}
