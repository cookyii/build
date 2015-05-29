<?php
/**
 * AbstractConfigReader.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\config;

use Symfony\Component\Console;

/**
 * Class AbstractConfigReader
 * @package cookyii\build\config
 */
abstract class AbstractConfigReader extends \cookyii\build\components\Component
{

    /** @var string|null */
    public $configFile;

    /** @var string */
    public $basePath;

    /** @var \cookyii\build\commands\BuildCommand */
    public $command;

    /** @var Console\Input\InputInterface */
    public $input;

    /** @var Console\Output\OutputInterface */
    public $output;

    /**
     * @param \cookyii\build\commands\BuildCommand $BuildCommand
     */
    public function __construct($BuildCommand)
    {
        $this->command = $BuildCommand;
        $this->input = $BuildCommand->input;
        $this->output = $BuildCommand->output;

        $this->configFile = realpath($this->input->getOption('config'));
        $this->basePath = dirname($this->configFile);
    }

    /**
     * @param string $message
     */
    public function log($message)
    {
        if (!empty($this->output)) {
            $this->output->writeln($message);
        }
    }

    /**
     * @return array|false
     */
    abstract function read();

    /**
     * @param array $config
     * @return array
     */
    public function expandCompositeTasks(array $config)
    {
        if (!empty($config)) {
            foreach ($config as $task => $conf) {
                if (isset($conf['class']) && !empty($conf['class'])) {
                    $Task = new $conf['class']($this->command);

                    if ($Task instanceof \cookyii\build\tasks\AbstractCompositeTask) {
                        $tasks = $Task->tasks();
                        if (!empty($tasks)) {
                            $config[$task] = array_merge($conf, $tasks);
                        }
                    }
                }
            }
        }

        return $config;
    }
}