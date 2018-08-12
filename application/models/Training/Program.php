<?php

/**
 * Description of Application_Model_Training_Program
 *
 * @author Voß
 */
class Application_Model_Training_Program
{

    /**
     * @var int
     */
    private $programId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;

    /**
     * @var Application_Model_Training_Attribute
     */
    private $primaryAttribute;
    /**
     * @var Application_Model_Training_Attribute
     */
    private $secondaryAttribute;
    /**
     * @var Application_Model_Training_Attribute[]
     */
    private $optionalAttributes = [];
    /**
     * @var Application_Model_Training_Attribute[]
     */
    private $decreasingAttributes = [];

    /**
     * @var int
     */
    private $remainingDuration;

    /**
     * @return int
     */
    public function getProgramId ()
    {
        return $this->programId;
    }

    /**
     * @param int $programId
     */
    public function setProgramId ($programId)
    {
        $this->programId = $programId;
    }

    /**
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription ($description)
    {
        $this->description = $description;
    }

    /**
     * @return Application_Model_Training_Attribute
     */
    public function getPrimaryAttribute ()
    {
        return $this->primaryAttribute;
    }

    /**
     * @param Application_Model_Training_Attribute $primaryAttribute
     */
    public function setPrimaryAttribute (Application_Model_Training_Attribute $primaryAttribute)
    {
        $this->primaryAttribute = $primaryAttribute;
    }

    /**
     * @return Application_Model_Training_Attribute
     */
    public function getSecondaryAttribute ()
    {
        return $this->secondaryAttribute;
    }

    /**
     * @param Application_Model_Training_Attribute $secondaryAttribute
     */
    public function setSecondaryAttribute (Application_Model_Training_Attribute $secondaryAttribute)
    {
        $this->secondaryAttribute = $secondaryAttribute;
    }

    /**
     * @return Application_Model_Training_Attribute[]
     */
    public function getOptionalAttributes ()
    {
        return $this->optionalAttributes;
    }

    /**
     * @return Application_Model_Training_Attribute
     */
    public function getRandomOptionalAttribute ()
    {
        return $this->optionalAttributes[mt_rand(0, count($this->optionalAttributes) - 1)];
    }

    /**
     * @param Application_Model_Training_Attribute[] $optionalAttributes
     */
    public function setOptionalAttributes (array $optionalAttributes)
    {
        $this->optionalAttributes = $optionalAttributes;
    }

    /**
     * @param Application_Model_Training_Attribute $optionalAttribute
     */
    public function addOptionalAttribute (Application_Model_Training_Attribute $optionalAttribute)
    {
        $this->optionalAttributes[] = $optionalAttribute;
    }

    /**
     * @return int
     */
    public function getRemainingDuration ()
    {
        return $this->remainingDuration;
    }

    /**
     * @param int $remainingDuration
     */
    public function setRemainingDuration ($remainingDuration)
    {
        $this->remainingDuration = $remainingDuration;
    }


    /**
     * @param $attributes Application_Model_Training_Attribute[]
     */
    public function setDecreasingAttributes (array $attributes)
    {
        $this->decreasingAttributes = $attributes;
    }

    /**
     * @return Application_Model_Training_Attribute[]
     */
    public function getDecreasingAttributes ()
    {
        if (!empty($this->decreasingAttributes)) {
            return $this->decreasingAttributes;
        }
        $returnArray = [];
        foreach (Application_Model_Training_Attribute::getAttributeKeys() as $attribute) {
            if (in_array(
                $attribute, [
                $this->primaryAttribute->getAttributeKey(), $this->secondaryAttribute->getAttributeKey()]
            )) {
                continue;
            }
            try {
                $returnArray[] = new Application_Model_Training_Attribute($attribute);
            } catch (Exception $exception) {
                // kann nicht passieren
            }
        }
        return $returnArray;
    }

    /**
     * @param array $excludedAttributes
     *
     * @return Application_Model_Training_Attribute
     */
    public function getRandomDecreasingAttribute ($excludedAttributes = [])
    {
        if (empty($this->decreasingAttributes)) {
            $this->decreasingAttributes = $this->getDecreasingAttributes();
        }
        return $this->decreasingAttributes[mt_rand(0, count($this->decreasingAttributes) - 1)];
    }


    public function toArray()
    {
        $program = [
            'programId' => $this->getProgramId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'primary' => [
                'attribute' => $this->getPrimaryAttribute()->getAttributeKey(),
                'value' => $this->getPrimaryAttribute()->getValue()
            ],
            'secondary' => [
                'attribute' => $this->getSecondaryAttribute()->getAttributeKey(),
                'value' => $this->getSecondaryAttribute()->getValue()
            ],
            'optional' => [],
            'decreasing' => [],
        ];
        foreach ($this->getOptionalAttributes() as $attribute) {
            $program['optional'][] = [
                'attribute' => $attribute->getAttributeKey(),
                'value' => $attribute->getValue()
            ];
        }
        foreach ($this->getDecreasingAttributes() as $attribute) {
            $program['decreasing'][] = [
                'attribute' => $attribute->getAttributeKey(),
                'value' => $attribute->getValue()
            ];
        }
        return $program;
    }

}
