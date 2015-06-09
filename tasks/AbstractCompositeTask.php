<?php
/**
 * AbstractCompositeTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
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

            return $this->command->executeTask($task, $this->prefix . '[' . $defaultTask . ']', $this->indent);
        }
    }
}