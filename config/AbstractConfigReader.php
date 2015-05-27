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

    /** @var Console\Input\InputInterface */
    public $input;

    /** @var Console\Output\OutputInterface */
    public $output;

    /**
     * @param Console\Input\InputInterface $input
     * @param Console\Output\OutputInterface $output
     */
    public function __construct(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $this->configFile = realpath($input->getOption('config'));
        $this->basePath = dirname($this->configFile);

        $this->input = $input;
        $this->output = $output;
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
}