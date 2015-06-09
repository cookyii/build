<?php
/**
 * EchoTask.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class EchoTask
 * @package cookyii\build\tasks
 */
class EchoTask extends AbstractTask
{

    /** @var string|array|null */
    public $message;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->message)) {
            throw new \InvalidArgumentException('Empty message.');
        } else {
            if (is_string($this->message)) {
                $this->message = [$this->message];
            }

            foreach ($this->message as $message) {
                $this->log(sprintf('<task-result> ECHO </task-result> %s', $message));
            }

            return true;
        }
    }
}