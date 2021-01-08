<?php

/**
 * Description of Application_Model_Charakterwertecategory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwertecategory
{

    private $category;
    private $numericValue = 1;

    public function getCategory ()
    {
        return $this->category;
    }

    public function setCategory ($category)
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getNumericValue (): int
    {
        return $this->numericValue;
    }

    /**
     * @param int $numericValue
     *
     * @return Application_Model_Charakterwertecategory
     */
    public function setNumericValue (int $numericValue): Application_Model_Charakterwertecategory
    {
        $this->numericValue = $numericValue;
        return $this;
    }

}
