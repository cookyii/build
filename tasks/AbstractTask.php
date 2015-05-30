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

    /** @var string|null */
    public $description;

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

    /**
     * @param \cookyii\build\commands\BuildCommand $BuildCommand
     */
    public function __construct($BuildCommand)
    {
        $this->command = $BuildCommand;
        $this->input = $BuildCommand->input;
        $this->output = $BuildCommand->output;
    }

    /**
     * Send message to output
     * @param string $message
     * @param integer $indent
     */
    public function log($message, $indent = 0)
    {
        $this->command->log($message, $indent + $this->indent + 1);
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