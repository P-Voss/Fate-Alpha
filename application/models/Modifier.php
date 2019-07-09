<?php

/**
 * Description of modifier
 *
 * @author Voß
 */
class Application_Model_Modifier
{

    /**
     * @var string
     */
    protected $attribute;
    /**
     * @var int
     */
    protected $value;

    /**
     * @return string
     */
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

    /**
     * @param $attribute
     */
    public function setAttribute ($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @param $value
     */
    public function setValue ($value)
    {
        $this->value = $value;
    }

}
