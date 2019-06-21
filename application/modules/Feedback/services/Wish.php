<?php


namespace Feedback\Services;

use Application_Model_Mapper_UserMapper;
use Feedback\Models\Mappers\WishMapper;
use Feedback\Models\Wish as WishModel;

class Wish
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
     * @param WishModel $wish
     *
     * @return int
     * @throws \Exception
     */
    public function create (WishModel $wish)
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
     * @return WishModel
     * @throws \Exception
     */
    public function load ($wishId)
    {
        return $this->wishMapper->load($wishId);
    }

}