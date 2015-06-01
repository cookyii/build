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
    public static function onBeforeConfigureTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_BEFORE_CONFIGURE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterConfigureTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_AFTER_CONFIGURE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onBeforeRunTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_BEFORE_RUN_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterRunTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a listener on event %s', BuildCommand::EVENT_AFTER_RUN_TASK));
    }
}