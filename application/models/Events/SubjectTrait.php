<?php


trait Application_Model_Events_SubjectTrait
{
    /**
     * @var SplObserver[]
     */
    protected $observers = [];

    /**
     * @param SplObserver $observer
     */
    public function attach (SplObserver $observer)
    {
        $this->observers[spl_object_hash($observer)] = $observer;
    }

    /**
     * @param SplObserver $observer
     */
    public function detach (SplObserver $observer)
    {
        unset($this->observers[spl_object_hash($observer)]);
    }

    /**
     *
     */
    public function notify ()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * @return array
     */
    public function getEvents (): array
    {
        return $this->events;
    }

}