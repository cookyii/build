<?php
/**
 * BlankTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class BlankTask
 * @package cookyii\build\tasks
 */
class BlankTask extends AbstractTask
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->output->isVerbose()) {
            $this->log('Blank task executed.');
        }

        return true;
    }
}