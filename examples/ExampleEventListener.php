<?php
/**
 * ExampleEventListener.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\examples;

use cookyii\build\commands\BuildCommand;
use cookyii\build\events\TaskEvent;

/**
 * Class ExampleEventListener
 * @package cookyii\build\examples
 */
class ExampleEventListener
{

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onBeforeCreateTaskObject(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_BEFORE_EXECUTE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterCreateTaskObject(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_AFTER_CREATE_TASK_OBJECT));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onBeforeExecuteTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_BEFORE_EXECUTE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterExecuteTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_AFTER_EXECUTE_TASK));
    }
}