<?php
/**
 * ComposerTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tasks;

/**
 * Class ComposerTask
 * @package cookyii\build\tasks
 */
class ComposerTask extends AbstractCompositeTask
{

    /** @var string composer execute file */
    public $composer = 'composer';

    /**
     * @inheritdoc
     */
    public function tasks()
    {
        return [
            'default' => [
                '.description' => 'Show map tasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'install-dev' => [
                '.description' => 'Install all depending for development environment (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist',
                ],
            ],
            'update-dev' => [
                '.description' => 'Update all depending for development environment (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist',
                ],
            ],

            'install' => [
                '.description' => 'Install all depending for productions environment (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist --no-dev',
                ],
            ],
            'update' => [
                '.description' => 'Update all depending for productions environment (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist --no-dev',
                ],
            ],

            'selfupdate' => [
                '.description' => 'Update composer script',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' selfupdate',
                ],
            ],
            'self-update' => [
                '.description' => 'Update composer script (alias for `selfupdate`)',
                '.depends' => ['*/selfupdate'],
            ]
        ];
    }
}