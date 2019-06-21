<?php


namespace Notification\Models\Mappers;

use Feedback\Models\Notification;

/**
 * Class NotificationMapper
 * @package Notification\models\mappers
 */
abstract class NotificationMapper
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
     * @param int $userId
     *
     * @return Notification[]
     */
    abstract public function loadByUserId(int $userId): array;

    /**
     * @param Notification $notification
     *
     * @return int
     * @throws \Exception
     */
    public function create(Notification $notification): int
    {
        return $this->getDbTable('Notification')->insert($notification->toArray());
    }

    /**
     * @param int $notificationId
     *
     * @throws \Exception
     */
    final public function remove (int $notificationId)
    {
        $this->getDbTable('Notification')->delete(['notificationId = ?' => $notificationId]);
    }


}