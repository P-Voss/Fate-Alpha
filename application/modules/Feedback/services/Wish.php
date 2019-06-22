<?php


namespace Feedback\Services;

use Feedback\Models\Mappers\WishMapper;
use Feedback\Models\Wish as WishModel;

class Wish implements \Application_Model_Events_Subject
{

    use \Application_Model_Events_SubjectTrait;

    const NEW_WISH_EVENT = 'NEW_WISH';

    /**
     * @var array
     */
    private $events = [];

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
        $wishId = $this->wishMapper->create($wish);
        $this->events[] = ['event' => self::NEW_WISH_EVENT, 'wishId' => $wishId];
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