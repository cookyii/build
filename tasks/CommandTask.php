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

    /** @var callable|null */
    public $callback;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->commandline)) {
            throw new \InvalidArgumentException('Empty command.');
        } else {
            $cwd = $this->command->configReader->basePath;

            if (!empty($this->cwd)) {
                $cwd = $this->cwd;
            }

            if (is_string($this->commandline)) {
                $this->commandline = [$this->commandline];
            }

            foreach ($this->commandline as $command) {
                if ($this->output->isVerbose()) {
                    $this->log(sprintf('Executing "%s"', $command));
                    $this->log(sprintf('in "%s"', $cwd));
                }

                $commands = [
                    sprintf('cd %s', escapeshellarg($cwd)),
                    $command,
                ];

                passthru(implode(' && ', $commands), $return);

                if (is_callable($this->callback)) {
                    call_user_func($this->callback, $this, $return);
                }

                if ($return !== 0) {
                    return false;
                }
            }

            return true;
        }
    }
}