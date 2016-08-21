<?php
/**
 * InputTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

use cookyii\build\components\Console;

/**
 * Class InputTask
 * @package cookyii\build\tasks
 */
class InputTask extends AbstractTask
{

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $message;

    /**
     * @return bool
     */
    public function run()
    {
        if (empty($this->state)) {
            throw new \InvalidArgumentException('Empty state key.');
        }

        if (empty($this->message)) {
            throw new \InvalidArgumentException('Empty prompt message.');
        }

        $answer = $this->input->getArgument('arg1');

        if (empty($answer)) {
            if ($this->output->isVeryVerbose()) {
                $this->log('<log> LOG </log> empty answer, send prompt.');
            }

            $this->log('<prompt> ANSWER </prompt> ', 0, false);
            $this->command->setState($this->state, Console::prompt($this->message));
        } else {
            if ($this->output->isVeryVerbose()) {
                $this->log('<log> LOG </log> not empty answer, prompt ignore');
            }

            $this->command->setState($this->state, $answer);
        }

        if ($this->output->isVerbose()) {
            $this->log(sprintf(
                '<task-result> STATE </task-result> %s = "%s".',
                $this->state,
                $this->command->getState($this->state)
            ));
        }

        return true;
    }
}
