<?php
/**
 * CommandTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
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
                $cwd = $this->getAbsolutePath($this->cwd);
            }

            if (is_string($this->commandline)) {
                $this->commandline = [$this->commandline];
            }

            $result = true;

            foreach ($this->commandline as $command) {
                if ($this->output->isVerbose()) {
                    $this->log(sprintf('<task-result> EXEC </task-result> cwd "%s"', $cwd));
                    $this->log(sprintf('<task-result> EXEC </task-result> "%s"', $command));
                }

                $commands = [
                    sprintf('cd %s', escapeshellarg($cwd)),
                    $command,
                ];

                passthru(implode(' && ', $commands), $return);

                $result = $result && $return === 0;

                if ($result == false) {
                    $this->log(sprintf('<task-error> ERR </task-error> <error>Bad exit code in command "%s"</error>.', $command));
                    break;
                }
            }

            return $result;
        }
    }
}