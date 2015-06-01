<?php
/**
 * ExampleEventSubscriber.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\examples;

use cookyii\build\commands\BuildCommand;
use cookyii\build\events\TaskEvent;

/**
 * Class ExampleEventSubscriber
 * @package cookyii\build\examples
 */
class ExampleEventSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            BuildCommand::EVENT_BEFORE_CONFIGURE_TASK => ['onBeforeConfigureTask', 0],
            BuildCommand::EVENT_AFTER_CONFIGURE_TASK => ['onAfterConfigureTask', 0],
            BuildCommand::EVENT_BEFORE_RUN_TASK => ['onBeforeRunTask', 0],
            BuildCommand::EVENT_AFTER_RUN_TASK => ['onAfterRunTask', 0],
        ];
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onBeforeConfigureTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber on event %s', BuildCommand::EVENT_BEFORE_CONFIGURE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onAfterConfigureTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber on event %s', BuildCommand::EVENT_AFTER_CONFIGURE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onBeforeRunTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber on event %s', BuildCommand::EVENT_BEFORE_RUN_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onAfterRunTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber on event %s', BuildCommand::EVENT_AFTER_RUN_TASK));
    }
}