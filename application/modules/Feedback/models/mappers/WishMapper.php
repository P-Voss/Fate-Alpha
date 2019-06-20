<?php


namespace Feedback\Models\Mappers;


use Feedback\Models\Wish;

class WishMapper
{

    /**
     * @param string $adaptername
     *
     * @return \Zend_Db_Table_Abstract
     * @throws \Exception
     */
    private function getDbTable($adaptername): \Zend_Db_Table_Abstract
    {
        $className = 'Application_Model_DbTable_' . $adaptername;
        if (!class_exists($className)) {
            throw new \Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof \Zend_Db_Table_Abstract) {
            throw new \Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param Wish $wish
     *
     * @return int
     * @throws \Exception
     */
    public function create (Wish $wish)
    {
        return $this->getDbTable('Wishes')->insert($wish->toArray());
    }

    /**
     * @return array
     */
    public function loadAll ()
    {
        $wishes = [];
        try {
            foreach ($this->getDbTable('Wishes')->fetchAll() as $row) {
                $wish = new Wish();
                $wish->setWishId($row->wishId)
                    ->setTitle($row->title)
                    ->setDescription($row->description)
                    ->setUserId($row->userId)
                    ->setCreationDatetime($row->creationDatetime);
                $wishes[] = $wish;
            }
            return $wishes;
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param $wishId
     *
     * @return Wish
     * @throws \Exception
     */
    public function load ($wishId)
    {
        $row = $this->getDbTable('Wishes')->fetchRow(['wishId = ?' => $wishId]);
        if ($row === null) {
            throw new \Exception('Wish does not exist');
        }
        $wish = new Wish();
        $wish->setWishId($row->wishId)
            ->setTitle($row->title)
            ->setDescription($row->description)
            ->setUserId($row->userId)
            ->setCreationDatetime($row->creationDatetime);

        return $wish;
    }


}