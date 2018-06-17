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
     * @return Application_Model_Training_Attribute[]
     * @throws Exception
     */
    public function getDecreasingAttributes ()
    {
        $returnArray = [];
        $overallAttributes =  [
            'staerke', 'agilitaet', 'ausdauer', 'uebung', 'kontrolle', 'disziplin',
        ];
        foreach ($overallAttributes as $attribute) {
            if (in_array($attribute, [$this->primaryAttribute->getAttributeKey(), $this->secondaryAttribute->getAttributeKey()])) {
                continue;
            }
            $returnArray[] = new Application_Model_Training_Attribute($attribute);
        }
        return $returnArray;
    }

}
