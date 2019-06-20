<?php


namespace Feedback\Models;


/**
 * Class Wish
 * @package Feedback\Models
 */
class Wish
{

    /**
     * @var int
     */
    private $wishId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $creationDatetime;

    /**
     * @return int
     */
    public function getWishId (): int
    {
        return $this->wishId;
    }

    /**
     * @param int $wishId
     *
     * @return Wish
     */
    public function setWishId (int $wishId): Wish
    {
        $this->wishId = $wishId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle (): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Wish
     */
    public function setTitle (string $title): Wish
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription (): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Wish
     */
    public function setDescription (string $description): Wish
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId (): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return Wish
     */
    public function setUserId (int $userId): Wish
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getCreationDatetime ($format = 'd.m.Y H:i:s'): string
    {
        try {
            $datetime = new \DateTime($this->creationDatetime);
            return $datetime->format($format);
        } catch (\Exception $exception) {
            return '';
        }
    }

    /**
     * @param string $creationDatetime
     *
     * @return Wish
     */
    public function setCreationDatetime (string $creationDatetime): Wish
    {
        $this->creationDatetime = $creationDatetime;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        return [
            'wishId' => $this->wishId,
            'title' => $this->title,
            'description' => $this->description,
            'userId' => $this->userId,
        ];
    }

}