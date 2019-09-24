<?php

/**
 * Description of Application_Model_Training_Attribute
 *
 * @author Voß
 */
class Application_Model_Training_Attribute
{

    /**
     * @var string
     */
    private $attributeKey;
    /**
     * @var int
     */
    private $value;


    /**
     * @return array
     */
    private static function getAttributes() {
        return [
            'staerke' => 'Stärke',
            'agilitaet' => 'Agilität',
            'ausdauer' => 'Ausdauer',
            'uebung' => 'Übung',
            'kontrolle' => 'Kontrolle',
            'disziplin' => 'Disziplin',
        ];
    }

    /**
     * @return array
     */
    public static function getAttributeKeys() {
        return array_keys(self::getAttributes());
    }

    /**
     * @param $key
     *
     * @return string
     */
    public static function getAttributeName ($key)
    {
        $attributes = self::getAttributes();
        return $attributes[$key];
    }

    /**
     * @param string $key
     * @param int $value
     *
     * @throws Exception
     */
    public function __construct ($key = null, $value = 0)
    {

        if ($key !== null && !in_array($key, self::getAttributeKeys())) {
            throw new Exception('Attribut ' . $key . ' gibt es nicht.');
        }
        $this->attributeKey = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getAttributeKey ()
    {
        return $this->attributeKey;
    }

    /**
     * @return int
     */
    public function getValue ()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue ($value)
    {
        $this->value = $value;
    }

}
