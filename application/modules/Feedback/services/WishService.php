<?php


namespace Feedback\Services;

use Application_Model_Mapper_UserMapper;
use Feedback\Models\Mappers\WishMapper;
use Feedback\Models\Wish;

class WishService
{

    /**
     * @var WishMapper
     */
    private $wishMapper;

    public function __construct ()
    {
        $this->wishMapper = new WishMapper();
    }

    /**
     * @param Wish $wish
     *
     * @return int
     * @throws \Exception
     */
    public function create (Wish $wish)
    {
        $userMapper = new Application_Model_Mapper_UserMapper();
        $wishId = $this->wishMapper->create($wish);
        $userMapper->addNotificationForAdmins($wishId);
        return $wishId;
    }

    /**
     * @return array
     */
    public function loadAll ()
    {
        return $this->wishMapper->loadAll();
    }

    /**
     * @param $wishId
     *
     * @return Wish
     * @throws \Exception
     */
    public function load ($wishId)
    {
        return $this->wishMapper->load($wishId);
    }

}