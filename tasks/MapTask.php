<?php
/**
 * MapTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

use Symfony\Component\Console;

/**
 * Class MapTask
 * @package cookyii\build\tasks
 */
class MapTask extends AbstractTask
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->showTasks($this->command->config, null);

        return true;
    }

    /**
     * @param array $config
     * @param string|null $task
     * @param integer $indent
     */
    private function showTasks(array $config, $task = null, $indent = 0)
    {
        if ($task === null) {
            foreach ($config as $task => $conf) {
                $this->showTasks($conf, $task, $indent);
            }
        } else {
            if (isset($config['class']) || isset($config['depends'])) {
                $this->log(sprintf('<info>%s</info>', $task), $indent);
                if (isset($config['description']) && !empty($config['description'])) {
                    $words = preg_split('/\s+/u', trim($config['description']), null, PREG_SPLIT_DELIM_CAPTURE);
                    $chunks = array_chunk($words, 6);
                    foreach ($chunks as $chunk) {
                        $this->log(implode(' ', $chunk), $indent + 1);
                    }
                }

                if ($this->output->isVerbose()) {
                    if (isset($config['depends']) && !empty($config['depends'])) {
                        $this->log('<comment>[depends]</comment>', 1);
                        foreach ($config['depends'] as $depend) {
                            $this->log(sprintf(' * %s', $depend), 1);
                        }
                    }
                }

                $this->log('');
            }

            foreach ($config as $key => $value) {
                if ($key === 'class') {
                    continue;
                }

                if (is_array($value)) {
                    $this->showTasks($value, $task . '/' . $key, $indent);
                }
            }
        }
    }
}