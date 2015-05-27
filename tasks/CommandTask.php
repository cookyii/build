<?php
/**
 * CommandTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class CommandTask
 * @package cookyii\build\tasks
 */
class CommandTask extends AbstractTask
{

    /** @var string|array|null */
    public $commandline;

    /** @var string|null */
    public $cwd;

    /** @var array|null */
    public $env;

    /** @var callable|null */
    public $callback;

    /**
     * @return bool
     */
    public function run()
    {
        if (empty($this->commandline)) {
            throw new \InvalidArgumentException('Empty command.');
        } else {
            $basePath = $this->command->configReader->basePath;

            if (is_string($this->commandline)) {
                $this->commandline = [$this->commandline];
            }

            foreach ($this->commandline as $command) {
                if ($this->output->isVerbose()) {
                    $this->log(sprintf('Executing "%s"', $command));
                    $this->log(sprintf('in "%s"', $basePath));
                }

                $commands = [
                    sprintf('cd %s', escapeshellarg($basePath)),
                    $command,
                ];

                passthru(implode(' && ', $commands), $return);

                if ($return !== 0) {
                    return false;
                }
            }

            return true;
        }
    }
}