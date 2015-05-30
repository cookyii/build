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
    public $filename;

    public function run()
    {
        if (empty($this->filename)) {
            throw new \InvalidArgumentException('Empty lock file name.');
        }

        $this->filename = $this->getAbsolutePath($this->filename);

        $path = dirname($this->filename);

        if (!is_writable($path)) {
            throw new \RuntimeException(sprintf('Directory %s is not writable.', $path));
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
                '.description' => 'Show map tasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'disable' => [
                '.description' => 'Put a lock (alias for `lock`)',
                '.depends' => ['*/lock'],
            ],
            'lock' => [
                '.description' => 'Put a lock',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CallableTask',
                    'handler' => [$this, 'lock'],
                ],
            ],
            'enable' => [
                '.description' => 'Release a lock (alias for `release`)',
                '.depends' => ['*/release'],
            ],
            'release' => [
                '.description' => 'Release a lock',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CallableTask',
                    'handler' => [$this, 'release'],
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function lock()
    {
        if (!$this->getLockHandler()->lock()) {
            throw new \RuntimeException(sprintf('%s already locked.', $this->filename));
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
        return new \Symfony\Component\Filesystem\LockHandler($this->filename);
    }
}