<?php
/**
 * LockTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class LockTask
 * @package cookyii\build\tasks
 */
class LockTask extends AbstractCompositeTask
{

    /** @var string */
    public $name;

    /** @var string */
    public $lockPath;

    /** @var string|null */
    public $checkState;

    public function init()
    {
        parent::init();

        if (empty($this->name)) {
            throw new \InvalidArgumentException('Empty lock name.');
        }

        if (empty($this->lockPath)) {
            $this->lockPath = sys_get_temp_dir();
        }

        $this->lockPath = $this->getAbsolutePath($this->lockPath);
    }

    /**
     * @inheritdoc
     */
    public function tasks()
    {
        return [
            'default' => [
                '.description' => 'Show map tasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'lock' => [
                '.description' => 'Put a lock',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CallableTask',
                    'handler' => [$this, 'lock'],
                ],
            ],
            'release' => [
                '.description' => 'Release a lock',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CallableTask',
                    'handler' => [$this, 'release'],
                ],
            ],
            'check' => [
                '.description' => 'Send a lock state to command',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CallableTask',
                    'handler' => [$this, 'check'],
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function lock()
    {
        if ($this->output->isVeryVerbose()) {
            $this->log(sprintf('<task-result> LOCK </task-result> check file [%s].', $this->getFilename()));
        }

        if ($this->exists()) {
            throw new \RuntimeException(sprintf('[%s] already locked.', $this->name));
        }

        $this->getFileSystemHelper()
            ->touch($this->getFilename());

        if ($this->output->isVerbose()) {
            $this->log(sprintf('<task-result> LOCK </task-result> [%s].', $this->name));
        }

        return true;
    }

    /**
     * @return bool
     */
    public function release()
    {
        if ($this->output->isVeryVerbose()) {
            $this->log(sprintf('<task-result> RELEASE </task-result> check file [%s].', $this->getFilename()));
        }

        if (!$this->exists()) {
            throw new \RuntimeException(sprintf('Lock [%s] not exists.', $this->name));
        }

        $this->getFileSystemHelper()
            ->remove($this->getFilename());

        if ($this->output->isVerbose()) {
            $this->log(sprintf('<task-result> RELEASE </task-result> [%s].', $this->name));
        }

        return true;
    }

    /**
     * @return bool
     */
    public function check()
    {
        if (empty($this->checkState)) {
            throw new \RuntimeException('Empty check state name.');
        }

        $this->command->setState($this->checkState, $this->exists());

        if ($this->command->getState($this->checkState)) {
            $this->log(sprintf('<task-result> CHECK </task-result> Locked [%s].', $this->name));
        } else {
            $this->log(sprintf('<task-result> CHECK </task-result> Released [%s].', $this->name));
        }

        return true;
    }

    /**
     * @return bool
     */
    private function exists()
    {
        return file_exists($this->getFilename());
    }

    /**
     * @return string
     */
    private function getFilename()
    {
        return sprintf(
            '%s/build.%s.%s.lock',
            $this->lockPath,
            preg_replace('/[^a-z0-9\._-]+/i', '-', $this->name),
            hash('sha256', $this->name)
        );
    }
}