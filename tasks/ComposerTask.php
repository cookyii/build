<?php
/**
 * ComposerTask.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
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

    /** @var bool */
    public $quiet = false;

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
        $quiet = $this->quiet ? ' --quiet' : null;

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
                    'commandline' => $this->composer . ' require ' . $this->input->getArgument('arg1') . $quiet,
                    'cwd' => $this->cwd,
                ],
            ],

            'install-dev' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist' . $quiet,
                    'cwd' => $this->cwd,
                ],
            ],
            'update-dev' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (with `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist'. $quiet,
                    'cwd' => $this->cwd,
                ],
            ],

            'install' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' install --prefer-dist --no-dev'. $quiet,
                    'cwd' => $this->cwd,
                ],
            ],
            'update' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (without `require-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' update --prefer-dist --no-dev'. $quiet,
                    'cwd' => $this->cwd,
                ],
            ],

            'self-update' => [
                '.description' => 'Updates composer.phar to the latest version',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => $this->composer . ' selfupdate'. $quiet,
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