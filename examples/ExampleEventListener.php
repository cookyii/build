<?php
/**
 * ExampleEventListener.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
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
        if ($TaskEvent->getCommand()->output->isQuiet()) {
            $TaskEvent->log(sprintf('<comment> EVENT </comment> this is a listener on event %s', BuildCommand::EVENT_BEFORE_CONFIGURE_TASK));
        }
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterConfigureTask(TaskEvent $TaskEvent)
    {
        if ($TaskEvent->getCommand()->output->isVerbose()) {
            $TaskEvent->log(sprintf('<comment> EVENT </comment> this is a listener on event %s', BuildCommand::EVENT_AFTER_CONFIGURE_TASK));
        }
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onBeforeRunTask(TaskEvent $TaskEvent)
    {
        if ($TaskEvent->getCommand()->output->isVeryVerbose()) {
            $TaskEvent->log(sprintf('<comment> EVENT </comment> this is a listener on event %s', BuildCommand::EVENT_BEFORE_RUN_TASK));
        }
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public static function onAfterRunTask(TaskEvent $TaskEvent)
    {
        if ($TaskEvent->getCommand()->output->isDebug()) {
            $TaskEvent->log(sprintf('<comment> EVENT </comment> this is a listener on event %s', BuildCommand::EVENT_AFTER_RUN_TASK));
        }
    }
}