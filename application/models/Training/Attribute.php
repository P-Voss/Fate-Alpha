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
     * @param string $key
     *
     * @throws Exception
     */
    public function __construct ($key, $value = 0)
    {
        if (!in_array($key, $this->getAttributes())) {
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
     * @return array
     */
    private function getAttributes() {
        return [
            'staerke', 'agilitaet', 'ausdauer', 'uebung', 'kontrolle', 'disziplin',
        ];
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
