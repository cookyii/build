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
                '.description' => 'Show map subtasks',
                '.task' => [
                    'class' => 'cookyii\build\tasks\MapTask',
                    'task' => $this,
                ],
            ],

            'require' => [
                '.description' => 'Adds required packages to your composer.json and installs them',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' require ' . $this->input->getArgument('arg1'),
                    'cwd' => $this->cwd,
                ],
            ],

            'install-dev' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist',
                    'cwd' => $this->cwd,
                ],
            ],
            'update-dev' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist',
                    'cwd' => $this->cwd,
                ],
            ],

            'install' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist --no-dev',
                    'cwd' => $this->cwd,
                ],
            ],
            'update' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist --no-dev',
                    'cwd' => $this->cwd,
                ],
            ],

            'self-update' => [
                '.description' => 'Updates composer.phar to the latest version',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' selfupdate',
                    'cwd' => $this->cwd,
                ],
            ],
            'selfupdate' => [
                '.description' => 'Updates composer.phar to the latest version (alias for `self-update`)',
                '.depends' => ['*/self-update'],
            ]
        ];
    }
}