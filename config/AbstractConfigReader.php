<?php
/**
 * AbstractConfigReader.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\config;

use cookyii\build\components\Component;
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

    /** @var array */
    public static $reservedWords = ['.task', '.depends', '.description', '.events'];

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

    public static $depends_prefix = null;

    /**
     * @param array $config
     * @param string|null $task_prefix
     * @return array
     */
    public function expandConfig(array $config, $task_prefix = null)
    {
        $result = [];
        $subtasks = [];

        if (!empty($config)) {
            $config = $this->expandCompositeTasks($config);

            foreach ($config as $task => $conf) {
                if (in_array($task, ['.events', '.task', '.description'], true)) {
                    continue;
                }

                if (empty($task_prefix)) {
                    self::$depends_prefix = $task;
                }

                $task_key = empty($task_prefix)
                    ? $task
                    : ($task_prefix . $this->command->getDelimiter() . $task);

                if ($task !== '.depends' && is_array($conf) && !is_callable($conf)) {
                    $subtasks = array_merge($subtasks, $this->expandConfig($conf, $task_key));

                    foreach ($conf as $k => $v) {
                        if (!in_array($k, self::$reservedWords, true) && is_array($v) && !is_callable($v)) {
                            unset($conf[$k]);
                        }
                    }
                }

                if (is_array($conf)) {
                    foreach ($conf as $k => $v) {
                        if ($k === '.depends' && !empty($conf[$k])) {
                            foreach ($conf[$k] as $dependency_key => $dependency_name) {
                                $conf[$k][$dependency_key] = str_replace('*', self::$depends_prefix, $dependency_name);
                            }
                        }
                    }
                }

                if (!in_array($task, self::$reservedWords, true)) {
                    $result[$task_key] = $conf;
                }
            }
        }

        $result = array_merge($result, $subtasks);

        ksort($result);

        return $result;
    }

    /**
     * @param array $config
     * @return array
     */
    private function expandCompositeTasks(array $config)
    {
        if (!empty($config)) {
            foreach ($config as $task_name => $conf) {
                if (is_array($conf) && isset($conf['.task']) && !empty($conf['.task'])) {
                    $className = is_array($conf['.task'])
                        ? $conf['.task']['class']
                        : $conf['.task'];

                    $params = is_array($conf['.task'])
                        ? $conf['.task']
                        : [];

                    unset($params['class']);
                    $params['command'] = $this->command;

                    /** @var \cookyii\build\tasks\AbstractCompositeTask $Task */
                    $Task = Component::createObject($className, $params);

                    if ($Task instanceof \cookyii\build\tasks\AbstractCompositeTask) {
                        $tasks = $Task->tasks();
                        if (!empty($tasks)) {
                            $config[$task_name] = array_merge($conf, $tasks);
                        }
                    }
                }
            }
        }

        return $config;
    }
}