<?php
/**
 * BuildCommand.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\commands;

use Symfony\Component\Console;

/**
 * Class BuildCommand
 * @package cookyii\build\commands
 */
class BuildCommand extends AbstractCommand
{

    /** @var array */
    public $config = [];

    /** @var \cookyii\build\config\AbstractConfigReader */
    public $configReader;

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
            ->addOption('task-delimiter', 'd', Console\Input\InputOption::VALUE_OPTIONAL, 'Delimiter for the name of the task', '/');
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

            if (false === $this->executeTask($task, '[' . $task . ']', 0)) {
                $this->log('<task-error> TASK </task-error> <error>[' . $task . '] failure.</error>');

                $result = 1;
            }
        }

        $this->footer($started_at);

        return $result;
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
     * @param string|null $prefix
     * @param integer $indent
     * @return bool
     */
    private function executeTask($task_name, $prefix = null, $indent = 0)
    {
        $chunks = explode($this->input->getOption('task-delimiter'), $task_name);

        $task = $this->config;
        foreach ($chunks as $chunk) {
            if (!isset($task[$chunk])) {
                $this->log($prefix . ' task not found.');

                return false;
            } else {
                $task = $task[$chunk];
            }
        }

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
                $result = $this->executeTask($depend, $prefix . '[' . $depend . ']');

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

            /** @var \cookyii\build\tasks\AbstractTask $Task */
            $Task = (new $task['class']($this, $indent));

            $Task->configure($attributes);

            return $Task->run();
        }

        return true;
    }

    private function readConfig()
    {
        $this->configReader = $this->getConfigReader();
        $this->config = $this->configReader->read();
    }

    /**
     * @return \cookyii\build\config\AbstractConfigReader
     */
    private function getConfigReader()
    {
        switch ($this->input->getOption('config-type')) {
            default:
            case 'default':
                $result = new \cookyii\build\config\DefaultConfigReader($this->input, $this->output);
                break;
            case 'phing':
                $result = new \cookyii\build\config\PhingConfigReader($this->input, $this->output);
                break;
            case 'json':
                $result = new \cookyii\build\config\JsonConfigReader($this->input, $this->output);
                break;
        }

        return $result;
    }

    private function setStyles()
    {
        $Formatter = $this->output
            ->getFormatter();

        $Formatter->setStyle('error', new Console\Formatter\OutputFormatterStyle('red', null));
        $Formatter->setStyle('task', new Console\Formatter\OutputFormatterStyle('black', 'blue'));
        $Formatter->setStyle('task-error', new Console\Formatter\OutputFormatterStyle('black', 'red'));
        $Formatter->setStyle('task-result', new Console\Formatter\OutputFormatterStyle('black', 'yellow'));
        $Formatter->setStyle('header', new Console\Formatter\OutputFormatterStyle(null, null, ['bold']));
    }
}