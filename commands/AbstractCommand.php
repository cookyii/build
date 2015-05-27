<?php
/**
 * AbstractCommand.php
 * @author Revin Roman http://phptime.ru
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

    /**
     * @param string $message
     * @param integer $indent
     * @param boolean $newLine
     */
    public function log($message, $indent = 0, $newLine = true)
    {
        $method = $newLine ? 'writeln' : 'write';

        $messages = explode("\n", $message);
        foreach ($messages as $mes) {
            $this->output->$method(str_repeat('  ', $indent) . $mes);
        }
    }
}