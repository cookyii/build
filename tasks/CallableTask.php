<?php
/**
 * CallableTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class CallableTask
 * @package cookyii\build\tasks
 */
class CallableTask extends AbstractTask
{

    /**
     * @var callable|null
     * function(CallableTask $Task){
     *  return true;
     * }
     */
    public $handler;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!is_callable($this->handler)) {
            throw new \InvalidArgumentException('Empty handler.');
        } else {
            return call_user_func($this->handler, $this);
        }
    }
}