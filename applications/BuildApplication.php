<?php
/**
 * BuildApplication.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\applications;

use Symfony\Component\Console;

/**
 * Class BuildApplication
 * @package cookyii\build\applications
 */
class BuildApplication extends Console\Application
{

    /**
     * Gets the name of the command based on input.
     *
     * @param Console\Input\InputInterface $input The input interface
     *
     * @return string The command name
     */
    protected function getCommandName(Console\Input\InputInterface $input)
    {
        return 'build';
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return array An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new \cookyii\build\commands\BuildCommand();

        return $defaultCommands;
    }

    /**
     * Overridden so that the application doesn't expect the command
     * name to be the first argument.
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}