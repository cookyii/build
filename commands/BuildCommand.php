<?php
/**
 * BuildCommand.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\commands;

use cookyii\build\events\TaskEvent;
use Symfony\Component\Console;

/**
 * Class BuildCommand
 * @package cookyii\build\commands
 */
class BuildCommand extends AbstractCommand
{

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher */
    public $eventDispatcher;

    /** @var array */
    public $config = [];

    /** @var \cookyii\build\config\AbstractConfigReader */
    public $configReader;

    /** @var array */
    private $executed = [];

    const EVENT_BEFORE_CREATE_TASK_OBJECT = 'build.before.create.task.object';
    const EVENT_AFTER_CREATE_TASK_OBJECT = 'build.after.create.task.object';
    const EVENT_BEFORE_EXECUTE_TASK = 'build.before.execute.task';
    const EVENT_AFTER_EXECUTE_TASK = 'build.after.execute.task';

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('build')
            ->setDescription('Build current project')
            ->addArgument(
                'task',
                Console\Input\InputArgument::OPTIONAL,
                'What task you need to execute?',
                'default'
            )
            ->addOption('config', 'c', Console\Input\InputOption::VALUE_OPTIONAL, 'Where is the configuration file', 'build.php')
            ->addOption('config-type', 't', Console\Input\InputOption::VALUE_OPTIONAL, 'Config type (default, phing, json)', 'default')
            ->addOption('task-delimiter', 'd', Console\Input\InputOption::VALUE_OPTIONAL, 'Delimiter for the name of the task', '/')
            ->addOption('loop-threshold', 'l', Console\Input\InputOption::VALUE_OPTIONAL, 'Number of repetitions of the task to be discarded error loop', 3)
            ->addOption('color', null, Console\Input\InputOption::VALUE_OPTIONAL, 'Support colors in output', 'yes');

        $this->eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
    }

    /**
     * @param Console\Input\InputInterface $input
     * @param Console\Output\ConsoleOutput $output
     * @return integer
     */
    protected function execute(Console\Input\InputInterface $input, Console\Output\ConsoleOutput $output)
    {
        $result = 0;

        $started_at = microtime(true);

        $this->input = $input;
        $this->output = $output;

        $this->setStyles();

        $this->log('<task-result> CONF </task-result> Reading config... ', 0, false);

        $this->readConfig();
        $this->registerEventListeners();

        if (empty($this->config)) {
            $this->log('<error>Unable to read config file.</error>');

            if ($this->output->isVerbose()) {
                $this->log(sprintf('<comment>[config file]</comment> %s', $this->configReader->configFile), 1);
            }

            $result = 1;
        } else {
            $this->log('ok.');

            if ($this->output->isVerbose()) {
                $this->log(sprintf('<comment>[config file]</comment> %s', $this->configReader->configFile), 1);
            }

            $task = $input->getArgument('task');

            $this->log('');

            if (false === $this->executeTasks($this->config, $task, '[' . $task . ']', 0)) {
                $this->log('<task-error> TASK </task-error> <error>[' . $task . '] failure.</error>');

                $result = 1;
            }
        }

        $this->footer($started_at);

        return $result;
    }

    /**
     * @param array $tasks
     * @param string $task_name
     * @param string|null $prefix
     * @param integer $indent
     * @return bool
     */
    private function executeTasks(array $tasks, $task_name, $prefix = null, $indent = 0)
    {
        $this->detectLoop($task_name);

        $delimiter = $this->input->getOption('task-delimiter');
        $delimiter = empty($delimiter) ? '/' : $delimiter;

        $chunks = explode($delimiter, $task_name);

        if (empty($chunks)) {
            throw new \InvalidArgumentException(sprintf('Bad task name "%s".', $task_name));
        } else {
            // search among neighboring tasks
            $task = $tasks;

            if (empty($chunks[0])) {
                // search in all tasks
                $task = $this->config;
            }

            foreach ($chunks as $chunk) {
                if (!isset($task[$chunk])) {
                    $this->log($prefix . ' task not found.');

                    return false;
                } else {
                    $task = $task[$chunk];
                }
            }

            return $this->executeTask($tasks, $task, $prefix, $indent);
        }
    }

    /**
     * @param array $tasks
     * @param array $task
     * @param string $prefix
     * @param integer $indent
     * @return bool
     */
    public function executeTask(array $tasks, array $task, $prefix, $indent)
    {
        $this->log('<task> TASK </task> ' . $prefix);

        if (isset($task['depends']) && !empty($task['depends'])) {
            if ($this->output->isVerbose()) {
                $this->log('<comment>[depends]</comment>', $indent + 1);
                $chunks = array_chunk($task['depends'], 4);
                foreach ($chunks as $chunk) {
                    $this->log(implode(', ', $chunk), $indent + 2);
                }
            }

            foreach ($task['depends'] as $depend) {
                $result = $this->executeTasks($tasks, $depend, $prefix . '[' . $depend . ']');

                if (false === $result) {
                    $this->log('<task-error> TASK </task-error> <error>' . $prefix . '[' . $depend . '] failure.</error>');

                    return false;
                }
            }
        }

        if (isset($task['class'])) {
            if ($this->output->isVerbose()) {
                $this->log('<comment>[class]</comment> ', $indent + 1, false);
                $this->log($task['class']);
            }

            $attributes = $task;
            unset($attributes['class'], $attributes['depends']);

            if ($this->output->isDebug()) {
                $this->log('<comment>[attributes]</comment>', $indent + 1);
                $this->log(print_r($attributes, 1), $indent + 2);
            }

            $Event = new TaskEvent($this, $task, $indent + 1);

            if (!$this->raiseEvent(static::EVENT_BEFORE_CREATE_TASK_OBJECT, $Event)) {
                return false;
            }

            /** @var \cookyii\build\tasks\AbstractTask $Task */
            $Task = new $task['class']($this);

            $EventTask = new TaskEvent($this, $Task, $indent + 1);

            if (!$this->raiseEvent(static::EVENT_AFTER_CREATE_TASK_OBJECT, $EventTask)) {
                return false;
            }

            $attributes['prefix'] = $prefix;
            $attributes['indent'] = $indent;

            $Task->configure($attributes);

            if (!$this->raiseEvent(static::EVENT_BEFORE_EXECUTE_TASK, $EventTask)) {
                return false;
            }

            $result = $Task->run();

            if (!$this->raiseEvent(static::EVENT_AFTER_EXECUTE_TASK, $EventTask)) {
                return false;
            }

            return $result;
        }

        return true;
    }

    /**
     * @param string $event
     * @param TaskEvent $Event
     * @return bool
     */
    private function raiseEvent($event, TaskEvent $Event)
    {
        if ($this->output->isVeryVerbose()) {
            $this->log(sprintf('Raise event %s', $event), $Event->getIndent());
        }

        $this->eventDispatcher->dispatch($event, $Event);

        if ($Event->isPropagationStopped()) {
            $this->log(sprintf('<error>Event %s: Propagation stopped.</error>', $event), $Event->getIndent());

            return false;
        }

        return true;
    }

    /**
     * @param float $started_at
     */
    private function footer($started_at)
    {
        $delta = round(microtime(true) - $started_at);

        if ($delta <= 0) {
            $time = 'momentarily';
        } else {
            $hours = floor($delta / 3600);
            $minutes = floor(($delta - $hours * 3600) / 60);
            $seconds = $delta - $hours * 3600 - $minutes * 60;

            $time = [
                $hours > 0 ? ($hours . 'h') : null,
                $minutes > 0 ? ($minutes . 'm') : null,
                $seconds > 0 ? ($seconds . 's') : null,
            ];

            $time = implode(' ', $time);
        }

        $this->log("\n" . '<task-result> RES </task-result> <comment>Build finished.</comment>');
        $this->log('<task-result> RES </task-result> <comment>Total time: ' . $time . '</comment>');
    }

    /**
     * @param string $task_name
     */
    private function detectLoop($task_name)
    {
        $loop_threshold = (int)$this->input->getOption('loop-threshold');
        $loop_threshold = $loop_threshold <= 0 ? 3 : $loop_threshold;

        if (!isset($this->executed[$task_name])) {
            $this->executed[$task_name] = 0;
        }

        $this->executed[$task_name]++;

        if ($this->executed[$task_name] >= $loop_threshold) {
            $executed = array_flip($this->executed);
            ksort($executed);

            throw new \RuntimeException('Loop detected (' . array_pop($executed) . ' <> ' . array_pop($executed) . ').');
        }
    }

    private function readConfig()
    {
        $this->configReader = $this->getConfigReader();
        $this->config = $this->configReader->read();
    }

    private function registerEventListeners()
    {
        if (isset($this->config['.events'])) {
            $events = $this->config['.events'];
            unset($this->config['.events']);

            if (is_array($events) && !empty($events)) {
                foreach ($events as $eventName => $listener) {
                    $this->eventDispatcher->addListener($eventName, $listener);
                }
            }
        }
    }

    /**
     * @return \cookyii\build\config\AbstractConfigReader
     */
    private function getConfigReader()
    {
        switch ($this->input->getOption('config-type')) {
            default:
            case 'default':
                $result = new \cookyii\build\config\DefaultConfigReader($this);
                break;
            case 'phing':
                $result = new \cookyii\build\config\PhingConfigReader($this);
                break;
            case 'json':
                $result = new \cookyii\build\config\JsonConfigReader($this);
                break;
        }

        return $result;
    }

    private function setStyles()
    {
        $color = $this->input->getOption('color');

        $Formatter = $this->output
            ->getFormatter();

        $Formatter->setStyle('error', new Console\Formatter\OutputFormatterStyle('red', null));
        $Formatter->setStyle('task', new Console\Formatter\OutputFormatterStyle('black', 'blue'));
        $Formatter->setStyle('task-error', new Console\Formatter\OutputFormatterStyle('black', 'red'));
        $Formatter->setStyle('task-result', new Console\Formatter\OutputFormatterStyle('black', 'yellow'));
        $Formatter->setStyle('header', new Console\Formatter\OutputFormatterStyle(null, null, ['bold']));

        if (in_array($color, ['no', 'none', 'never'], true)) {
            $defaultStyle = new Console\Formatter\OutputFormatterStyle();

            $Formatter->setStyle('error', $defaultStyle);
            $Formatter->setStyle('info', $defaultStyle);
            $Formatter->setStyle('comment', $defaultStyle);
            $Formatter->setStyle('question', $defaultStyle);
            $Formatter->setStyle('task', $defaultStyle);
            $Formatter->setStyle('task-error', $defaultStyle);
            $Formatter->setStyle('task-result', $defaultStyle);
            $Formatter->setStyle('header', $defaultStyle);
        }
    }
}