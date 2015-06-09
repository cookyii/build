<?php
/**
 * AbstractCommand.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\commands;

use Symfony\Component\Console;

/**
 * Class AbstractCommand
 * @package cookyii\build\commands
 */
abstract class AbstractCommand extends Console\Command\Command
{

    /** @var Console\Input\InputInterface */
    public $input;

    /** @var Console\Output\ConsoleOutput */
    public $output;

    /** @var array */
    private $states = [];

    /**
     * @param string $message
     * @param integer $indent
     * @param boolean $newLine
     */
    public function log($message, $indent = 0, $newLine = true)
    {
        $method = $newLine ? 'writeln' : 'write';

        if (is_array($message) || is_object($message)) {
            $message = dump($message, 3, false, true);
        }

        $messages = explode("\n", $message);
        foreach ($messages as $mes) {
            $this->output->$method(str_repeat('  ', $indent) . $mes);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setState($key, $value)
    {
        $this->states[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getState($key, $defaultValue = null)
    {
        return isset($this->states[$key]) ? $this->states[$key] : $defaultValue;
    }
}