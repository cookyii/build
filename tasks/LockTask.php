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

    public function init()
    {
        parent::init();

        if (empty($this->name)) {
            throw new \InvalidArgumentException('Empty lock name.');
        }
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
        ];
    }

    /**
     * @return bool
     */
    public function lock()
    {
        if (!$this->getLockHandler()->lock()) {
            throw new \RuntimeException(sprintf('[%s] already locked.', $this->name));
        }

        if ($this->output->isVerbose()) {
            $this->log(sprintf('Locked [%s].', $this->name));
        }

        return true;
    }

    /**
     * @return bool
     */
    public function release()
    {
        $this->getLockHandler()->release();

        if ($this->output->isVerbose()) {
            $this->log(sprintf('Released [%s].', $this->name));
        }

        return true;
    }

    /**
     * @return \Symfony\Component\Filesystem\LockHandler
     */
    private function getLockHandler()
    {
        return new \Symfony\Component\Filesystem\LockHandler($this->name, $this->lockPath);
    }
}