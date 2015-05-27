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

    /** @var string */
    public $description;

    /** @var \cookyii\build\commands\BuildCommand */
    public $command;

    /** @var integer */
    public $indent;

    /** @var Console\Input\InputInterface */
    public $input;

    /** @var Console\Output\ConsoleOutput */
    public $output;

    /**
     * @param \cookyii\build\commands\BuildCommand $BuildCommand
     * @param integer $indent
     */
    public function __construct($BuildCommand, $indent)
    {
        $this->command = $BuildCommand;
        $this->indent = $indent;
        $this->input = $BuildCommand->input;
        $this->output = $BuildCommand->output;
    }

    /**
     * @param string $message
     * @param integer $indent
     */
    public function log($message, $indent = 0)
    {
        $this->command->log($message, $indent + $this->indent + 1);
    }

    /**
     * @return bool
     */
    abstract public function run();
}