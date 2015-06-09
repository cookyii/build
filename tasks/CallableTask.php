<?php
/**
 * CallableTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
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
     * function(CallableTask $Task, ...$params){
     *  return true;
     * }
     */
    public $handler;

    /** @var array */
    public $params = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!is_callable($this->handler)) {
            throw new \InvalidArgumentException('Empty handler.');
        } else {
            $result = call_user_func_array(
                $this->handler,
                array_merge([$this], $this->params)
            );

            if ($this->output->isVerbose()) {
                $this->log('<task-result> EXEC </task-result> Handler executed.');
            }

            return $result;
        }
    }
}