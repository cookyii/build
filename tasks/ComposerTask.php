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
                'depends' => ['install-dev'],
                'description' => 'Install all depending for development environment (with `require-dev`)',
            ],

            'install-dev' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Install all depending for development environment (with `require-dev`)',
                'commandline' => $this->composer . ' install --prefer-dist',
            ],
            'update-dev' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Update all depending for development environment (with `require-dev`)',
                'commandline' => $this->composer . ' update --prefer-dist',
            ],

            'install' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Install all depending for productions environment (without `require-dev`)',
                'commandline' => $this->composer . ' install --prefer-dist --no-dev',
            ],
            'update' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Update all depending for productions environment (without `require-dev`)',
                'commandline' => $this->composer . ' update --prefer-dist --no-dev',
            ],

            'selfupdate' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Update composer script',
                'commandline' => $this->composer . ' selfupdate',
            ],
            'self-update' => [
                'depends' => ['selfupdate'],
                'description' => 'Update composer script',
            ]
        ];
    }
}