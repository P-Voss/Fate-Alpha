<?php


namespace Notification\Models\Mappers;

use Notification\Models\Notification;

/**
 * Class NotificationMapper
 * @package Notification\models\mappers
 */
abstract class NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     */
    abstract public function loadByUserId(int $userId): array;

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
     * @param int $notificationType
     *
     * @return array
     * @throws \Exception
     */
    final protected function load (int $userId, int $notificationType): array
    {
        $notifications = [];
        $result = $this->getDbTable('Notification')->fetchAll(
            ['userId = ?' => $userId, 'type = ?' => $notificationType]
        );
        foreach ($result as $row) {
            $notification = new Notification();
            $notification->setUserId($userId)
                ->setNotificationId($row->notificationId)
                ->setSubjectId($row->subjectId)
                ->setType($notificationType);
            $notifications[] = $notification;
        }
        return $notifications;
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create(Notification $notification)
    {
        $this->getDbTable('Notification')->insert($notification->toArray());
    }

}