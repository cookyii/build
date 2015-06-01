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

    /** @var \cookyii\build\commands\BuildCommand */
    protected $command;

    /** @var array|\cookyii\build\tasks\AbstractTask */
    protected $task;

    /** @var string */
    protected $prefix;

    /** @var integer */
    protected $indent;

    /**
     * @param \cookyii\build\commands\BuildCommand $command
     * @param string $prefix
     * @param array|\cookyii\build\tasks\AbstractTask $task
     * @param integer $indent
     */
    public function __construct($command, $prefix, $task, $indent)
    {
        $this->command = $command;
        $this->prefix = $prefix;
        $this->task = $task;
        $this->indent = $indent;
    }

    /**
     * @return \cookyii\build\commands\BuildCommand
     */
    public function getCommand()
    {
        return $this->command;
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

    /**
     * @param string $message
     * @param integer $indent
     */
    public function log($message, $indent = 0)
    {
        $this->getCommand()->log($message, $this->indent + $indent);
    }
}