<?php
/**
 * SelfTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tasks;

/**
 * Class SelfTask
 * @package cookyii\build\tasks
 */
class SelfTask extends AbstractCompositeTask
{

    /** @var string composer execute file */
    public $composer = 'composer';

    /** @var string */
    public $cwd;

    public function init()
    {
        parent::init();

        if (empty($this->cwd)) {
            $this->cwd = $this->command->configReader->basePath;
        }
    }

    /**
     * @inheritdoc
     */
    public function tasks()
    {
        return [
            'default' => [
                '.description' => 'Show map of subtasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'update' => [
                '.description' => 'Self update `cookyii/build` package',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => sprintf(
                        '%s require cookyii/build %s',
                        $this->composer,
                        '--prefer-dist'
                    ),
                    'cwd' => $this->cwd,
                ],
            ],
        ];
    }
}