<?php

/**
 * Description of Application_Model_Training_Training
 *
 * @author Voß
 */
class Application_Model_Training_Training
{

    /**
     * @var Application_Model_Training_Program
     */
    private $program;
    /**
     * @var Application_Model_Training_Mods[]
     */
    private $mods = [];
    /**
     * @var Application_Model_Training_Mods[]
     */
    private $attributes = [];

    /**
     * Application_Model_Training_Training constructor.
     *
     * @param Application_Model_Training_Program $program
     * @param Application_Model_Training_Mods[] $mods
     */
    public function __construct (Application_Model_Training_Program $program, array $mods = [])
    {
        $this->program = $program;
        $this->mods = $mods;
    }

    /**
     * @param Application_Model_Training_Mods $mod
     */
    public function addMod (Application_Model_Training_Mods $mod)
    {
        $this->mods[] = $mod;
    }

    public function getCalculatedTraining ()
    {
        return $this->calculateTrainingValues();
    }


    private function calculateTrainingValues ()
    {
        $primaryAttribute = $this->program->getPrimaryAttribute();
        $primaryAttribute->setValue(Application_Model_Training_Defaultvalues::PRIMARY);
        $secondaryAttribute = $this->program->getSecondaryAttribute();
        $secondaryAttribute->setValue(Application_Model_Training_Defaultvalues::SECONDARY);

        $optionalAttributes = array_map(function(Application_Model_Training_Attribute $attr) {
            $attr->setValue(Application_Model_Training_Defaultvalues::OPTIONAL);
            return $attr;
        }, $this->program->getOptionalAttributes());

        $decreasingAttributes = array_map(function(Application_Model_Training_Attribute $attr) {
            $attr->setValue(Application_Model_Training_Defaultvalues::SUB);
            return $attr;
        }, $this->program->getDecreasingAttributes());
        $trainingAttributes = array_merge([$primaryAttribute, $secondaryAttribute], $optionalAttributes, $decreasingAttributes);

        Zend_Debug::dump($this->mods);
        exit;
        array_walk($this->mods, function ($mod) use ($trainingAttributes) {
            /** @var $attribute Application_Model_Training_Attribute */
            foreach ($trainingAttributes as $attribute) {
                if ($attribute->getAttributeKey() !== $mod->getAttribute()) {
                    continue;
                }
                $attribute->setValue($attribute->getValue() + $mod->getValue());
            }
        });
        Zend_Debug::dump($trainingAttributes);
        exit;
    }

}
