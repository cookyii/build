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
            BuildCommand::EVENT_BEFORE_CREATE_TASK_OBJECT => ['onBeforeCreateTaskObject', 0],
            BuildCommand::EVENT_AFTER_CREATE_TASK_OBJECT => ['onAfterCreateTaskObject', 0],
            BuildCommand::EVENT_BEFORE_EXECUTE_TASK => ['onBeforeExecuteTask', 0],
            BuildCommand::EVENT_AFTER_EXECUTE_TASK => ['onAfterExecuteTask', 0],
        ];
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onBeforeCreateTaskObject(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber on event %s', BuildCommand::EVENT_BEFORE_EXECUTE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onAfterCreateTaskObject(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber event %s', BuildCommand::EVENT_AFTER_CREATE_TASK_OBJECT));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onBeforeExecuteTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a subscriber event %s', BuildCommand::EVENT_BEFORE_EXECUTE_TASK));
    }

    /**
     * @param TaskEvent $TaskEvent
     */
    public function onAfterExecuteTask(TaskEvent $TaskEvent)
    {
        $TaskEvent->log(sprintf('this is a event %s', BuildCommand::EVENT_AFTER_EXECUTE_TASK));
    }
}