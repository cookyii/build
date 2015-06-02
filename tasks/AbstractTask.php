<?php
/**
 * AbstractTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

use Symfony\Component\Console;

/**
 * Class AbstractTask
 * @package cookyii\build\tasks
 */
abstract class AbstractTask extends \cookyii\build\components\Component
{

    /** @var \cookyii\build\commands\BuildCommand */
    public $command;

    /** @var Console\Input\InputInterface */
    public $input;

    /** @var Console\Output\ConsoleOutput */
    public $output;

    /** @var integer */
    public $indent = 0;

    /** @var string|null */
    public $prefix;

    /** @var bool */
    public $skipOnError = false;

    /** Events */
    const EVENT_AFTER_INITIALIZE = 'task.onAfterInitialize';
    const EVENT_BEFORE_RUN = 'task.onBeforeRun';
    const EVENT_AFTER_RUN = 'task.onAfterRun';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->input = $this->command->input;
        $this->output = $this->command->output;
    }

    /**
     * @return array
     */
    public function events()
    {
        return [];
    }

    /**
     * Send message to output
     * @param string $message
     * @param integer $indent
     * @param boolean $newLine
     */
    protected function log($message, $indent = 0, $newLine = true)
    {
        $this->command->log($message, $this->indent($indent), $newLine);
    }

    /**
     * @param integer $indent
     * @return integer
     */
    protected function indent($indent = 0)
    {
        return $indent + $this->indent + 1;
    }

    /**
     * Task logic
     * @return bool
     */
    abstract public function run();

    /**
     * @param $filename
     * @return string
     */
    protected function getAbsolutePath($filename)
    {
        if (!empty($filename) && !$this->getFileSystemHelper()->isAbsolutePath($filename)) {
            $filename = $this->command->configReader->basePath . DIRECTORY_SEPARATOR . $filename;
        }

        return $filename;
    }

    private $fs = null;

    /**
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    protected function getFileSystemHelper()
    {
        if ($this->fs === null) {
            $this->fs = new \Symfony\Component\Filesystem\Filesystem();
        }

        return $this->fs;
    }
}