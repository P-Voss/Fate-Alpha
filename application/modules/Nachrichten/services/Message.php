<?php

namespace Nachrichten\Services;

use Nachrichten\Models\Mappers\MessageMapper;

/**
 * Description of Nachrichten
 *
 * @author Voß
 */
class Message implements \Application_Model_Events_Subject
{

    use \Application_Model_Events_SubjectTrait;

    const NEW_MESSAGE_EVENT = 'NEW_PERSONAL_MESSAGE';
    const READ_MESSAGE_EVENT = 'READ_PERSONAL_MESSAGE';

    /**
     * @var array
     */
    private $events = [];

    /**
     * @var \Application_Model_Mapper_UserMapper
     */
    private $userMapper;
    /**
     * @var MessageMapper
     */
    private $mapper;


    /**
     * Nachrichten_Service_Nachrichten constructor.
     */
    public function __construct ()
    {
        $this->userMapper = new \Application_Model_Mapper_UserMapper();
        $this->mapper = new MessageMapper();
    }

    /**
     * @param int $userId
     *
     * @return \Nachrichten\Models\Message[]
     * @throws \Exception
     */
    public function getNachrichtenReceivedByUserId ($userId): array
    {
        $nachrichten = $this->mapper->getNachrichtenByReceiverId($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($this->mapper->getUserForPmById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($this->mapper->getUserForPmById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }

    /**
     * @param int $userId
     *
     * @return \Nachrichten\Models\Message[]
     * @throws \Exception
     */
    public function getNachrichtenSentByUserId ($userId)
    {
        $nachrichten = $this->mapper->getNachrichtenByDispatcherId($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($this->mapper->getUserForPmById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($this->mapper->getUserForPmById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }


    /**
     * @param $userId
     *
     * @return \Nachrichten\Models\Message[]
     * @throws \Exception
     */
    public function getNachrichtenArchivByUserId ($userId)
    {
        $nachrichten = $this->mapper->getNachrichtenarchivById($userId);
        foreach ($nachrichten as $nachricht) {
            $nachricht->setVerfasser($this->mapper->getUserForPmById($nachricht->getVerfasserId()));
            $nachricht->setEmpfaenger($this->mapper->getUserForPmById($nachricht->getEmpfaengerId()));
        }
        return $nachrichten;
    }

    /**
     * @param int $nachrichtId
     *
     * @return \Nachrichten\Models\Message
     * @throws \Exception
     */
    public function getNachrichtById ($nachrichtId)
    {
        $nachricht = $this->mapper->getNachrichtById($nachrichtId);
        $nachricht->setVerfasser($this->mapper->getUserForPmById($nachricht->getVerfasserId()));
        $nachricht->setEmpfaenger($this->mapper->getUserForPmById($nachricht->getEmpfaengerId()));
        return $nachricht;
    }

    /**
     * @param \Zend_Controller_Request_Http $request
     *
     * @throws \Exception
     */
    public function saveMessage (\Zend_Controller_Request_Http $request)
    {
        $nachricht = new \Nachrichten\Models\Message();
        $nachricht->setNachricht($request->getPost('nachricht'));
        $nachricht->setVerfasserId(\Zend_Auth::getInstance()->getIdentity()->userId);
        $nachricht->setEmpfaengerId($request->getPost('user'));
        $nachricht->setBetreff($request->getPost('betreff'));
        if ($request->getPost('admin') !== null) {
            $nachricht->setAdmin(true);
        } else {
            $nachricht->setAdmin(false);
        }
        $messageId = $this->mapper->saveMessage($nachricht);
        $this->events[] = ['event' => self::NEW_MESSAGE_EVENT, 'messageId' => $messageId];
    }

    /**
     * @param \Zend_Controller_Request_Http $request
     *
     * @throws \Exception
     */
    public function deleteMessage (\Zend_Controller_Request_Http $request)
    {
        $nachricht = $this->mapper->getNachrichtById($request->getParam('id'));
        if ($nachricht->getEmpfaengerId() === \Zend_Auth::getInstance()->getIdentity()->userId) {
            $this->mapper->deleteMessage($nachricht);
        }
    }

    /**
     * @param int $messageId
     *
     * @throws \Exception
     */
    public function readMessage ($messageId)
    {
        $this->mapper->setRead($messageId);
        $this->events[] = ['event' => self::READ_MESSAGE_EVENT, 'messageId' => $messageId];
    }

}
