<?php
/**
 * AbstractCompositeTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class AbstractCompositeTask
 * @package cookyii\build\tasks
 */
abstract class AbstractCompositeTask extends AbstractTask
{

    /** @var string default task */
    public $defaultTask = 'default';

    /**
     * List of children tasks
     * @return array
     */
    abstract public function tasks();

    /**
     * @inheritdoc
     */
    public function run()
    {
        $tasks = $this->tasks();
        $defaultTask = $this->defaultTask;

        if (!isset($tasks[$defaultTask])) {
            throw new \InvalidArgumentException(sprintf('Task "%s" not found.', $defaultTask));
        } else {
            $task = $tasks[$defaultTask];

            if ($this->output->isVerbose()) {
                $this->log(sprintf('Executing default task "%s".', $defaultTask));
            }

            $this->command->executeTask($tasks, $task, $this->prefix . '[' . $defaultTask . ']', $this->indent);
        }
    }
}