<?php


class Application_Model_TrainingLog
{

    /**
     * @var string
     */
    private $programName;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $errorMessage = '';
    /**
     * @var Application_Model_Training_Attribute[]
     */
    private $attributes = [];
    /**
     * @var Application_Model_Charakterwerte
     */
    private $statsBefore;
    /**
     * @var Application_Model_Charakterwerte
     */
    private $statsAfter;

    /**
     * @return string
     */
    public function getProgramName ()
    {
        return $this->programName;
    }

    /**
     * @param string $programName
     *
     * @return Application_Model_TrainingLog
     */
    public function setProgramName ($programName)
    {
        $this->programName = $programName;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getDate ($format = 'd.m.Y')
    {
        if ($this->date !== '') {
            $date = new DateTime($this->date);
            return $date->format($format);
        }
        return '';
    }

    /**
     * @param string $date
     *
     * @return Application_Model_TrainingLog
     */
    public function setDate ($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Application_Model_Training_Attribute[]
     */
    public function getAttributes (): array
    {
        return $this->attributes;
    }

    /**
     * @param Application_Model_Training_Attribute[] $attributes
     *
     * @return Application_Model_TrainingLog
     */
    public function setAttributes (array $attributes): Application_Model_TrainingLog
    {
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }
        return $this;
    }

    /**
     * @param Application_Model_Training_Attribute $attribute
     *
     * @return Application_Model_TrainingLog
     */
    public function addAttribute (Application_Model_Training_Attribute $attribute): Application_Model_TrainingLog
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage (): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     *
     * @return Application_Model_TrainingLog
     */
    public function setErrorMessage (string $errorMessage): Application_Model_TrainingLog
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return bool
     */
    public function isError (): bool
    {
        return $this->errorMessage !== '';
    }

    /**
     * @return Application_Model_Charakterwerte
     */
    public function getStatsBefore (): Application_Model_Charakterwerte
    {
        return $this->statsBefore;
    }

    /**
     * @param Application_Model_Charakterwerte $statsBefore
     *
     * @return Application_Model_TrainingLog
     */
    public function setStatsBefore (Application_Model_Charakterwerte $statsBefore): Application_Model_TrainingLog
    {
        $this->statsBefore = $statsBefore;
        return $this;
    }

    /**
     * @return Application_Model_Charakterwerte
     */
    public function getStatsAfter (): Application_Model_Charakterwerte
    {
        return $this->statsAfter;
    }

    /**
     * @param Application_Model_Charakterwerte $statsAfter
     *
     * @return Application_Model_TrainingLog
     */
    public function setStatsAfter (Application_Model_Charakterwerte $statsAfter): Application_Model_TrainingLog
    {
        $this->statsAfter = $statsAfter;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $statsBefore = [];
        foreach ($this->statsBefore->toArray() as $key => $value) {
            $statsBefore[] = $key . ':' . $value;
        }
        $statsAfter = [];
        foreach ($this->statsAfter->toArray() as $key => $value) {
            $statsAfter[] = $key . ':' . $value;
        }
        return [
            'programName' => $this->programName,
            'errorMessage' => $this->errorMessage,
            'date' => $this->date,
            'attributes' => implode(',', array_map(function (Application_Model_Training_Attribute $attribute) {
                return $attribute->getAttributeKey() . ':' . $attribute->getValue();
            }, $this->attributes)),
            'statsBefore' => implode(',', $statsBefore),
            'statsAfter' => implode(',', $statsAfter),
        ];
    }

}