<?php

/**
 * Description of Application_Model_Training_Mods
 *
 * @author Voß
 */
class Application_Model_Training_Mods
{

    /**
     * @var string
     */
    private $attribute;
    /**
     * @var int
     */
    private $value;

    /**
     * @param $attribute
     * @param int $value
     *
     * @throws Exception
     */
    public function __construct ($attribute, $value = 0)
    {
        if (!in_array($attribute, Application_Model_Training_Attribute::getAttributeKeys())) {
            throw new Exception('Attribut ' . $attribute . ' gibt es nicht.');
        }
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function getAttribute ()
    {
        return $this->attribute;
    }

    /**
     * @return int
     */
    public function getValue ()
    {
        return $this->value;
    }

}
