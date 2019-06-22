<?php


namespace Notification\Models\Mappers;


use Notification\Models\Notification;

/**
 * Class General
 * @package Notification\Models\Mappers\Types
 */
class General
{

    /**
     * @param string $adaptername
     *
     * @return \Zend_Db_Table_Abstract
     * @throws \Exception
     */
    protected function getDbTable($adaptername): \Zend_Db_Table_Abstract
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
     * @param int $notificationId
     *
     * @return Notification
     * @throws \Exception
     */
    public function load (int $notificationId): Notification
    {
        $row = $this->getDbTable('Notification')->fetchRow(
            ['notificationId = ?' => $notificationId]
        );
        if ($row === null) {
            throw new \Exception('Notification does not exist');
        }
        $notification = new Notification();
        $notification->setUserId($row->userId)
            ->setNotificationId($row->notificationId)
            ->setSubjectId($row->subjectId)
            ->setType($row->type);

        return $notification;
    }

    /**
     * @param int $notificationId
     *
     * @throws \Exception
     */
    public function remove (int $notificationId)
    {
        $this->getDbTable('Notification')->delete(['notificationId = ?' => $notificationId]);
    }

}