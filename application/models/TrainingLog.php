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
     * @return mixed
     */
    public function getProgramName ()
    {
        return $this->programName;
    }

    /**
     * @param mixed $programName
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
     * @param mixed $date
     *
     * @return Application_Model_TrainingLog
     */
    public function setDate ($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return array
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

}