<?php
/**
 * TaskEvent.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\events;

/**
 * Class TaskEvent
 * @package cookyii\build\events
 */
class TaskEvent extends \Symfony\Component\EventDispatcher\Event
{

    /** @var array|\cookyii\build\tasks\AbstractTask */
    protected $task;

    /** @var int */
    protected $indent;

    /**
     * @param array|\cookyii\build\tasks\AbstractTask $task
     * @param integer $indent
     */
    public function __construct($task, $indent)
    {
        $this->task = $task;
        $this->indent = $indent;
    }

    /**
     * @return array|\cookyii\build\tasks\AbstractTask
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return integer
     */
    public function getIndent()
    {
        return $this->indent;
    }
}