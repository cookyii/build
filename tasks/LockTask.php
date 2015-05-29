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
    public $lockFile;

    public function run()
    {
        if (empty($this->lockFile)) {
            throw new \InvalidArgumentException('Empty lock file name.');
        }

        $lockFilePath = dirname($this->lockFile);

        if (!is_writable($lockFilePath)) {
            throw new \RuntimeException(sprintf('Directory %s is not writable.', $lockFilePath));
        }

        parent::run();
    }

    /**
     * @inheritdoc
     */
    public function tasks()
    {
        return [
            'default' => [
                'class' => 'cookyii\build\tasks\MapTask',
                'description' => 'Show map tasks',
                'task' => $this,
            ],

            'disable' => [
                'depends' => ['*/lock'],
                'description' => 'Put a lock (alias for `lock`)',
            ],
            'lock' => [
                'class' => 'cookyii\build\tasks\CallableTask',
                'description' => 'Put a lock',
                'handler' => [$this, 'lock'],
            ],
            'enable' => [
                'depends' => ['*/release'],
                'description' => 'Release a lock (alias for `release`)',
            ],
            'release' => [
                'class' => 'cookyii\build\tasks\CallableTask',
                'description' => 'Release a lock',
                'handler' => [$this, 'release'],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function lock()
    {
        if (!$this->getLockHandler()->lock()) {
            throw new \RuntimeException(sprintf('%s already locked.', $this->lockFile));
        }

        return true;
    }

    /**
     * @return bool
     */
    public function release()
    {
        $this->getLockHandler()->release();

        return true;
    }

    /**
     * @return \Symfony\Component\Filesystem\LockHandler
     */
    private function getLockHandler()
    {
        return new \Symfony\Component\Filesystem\LockHandler($this->lockFile);
    }
}