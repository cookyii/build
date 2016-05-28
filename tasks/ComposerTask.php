<?php
/**
 * ComposerTask.php
 * @author Revin Roman
 * @license The MIT License (MIT)
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

    /** @var bool */
    public $verbose = false;

    /** @var bool */
    public $profile = false;

    /** @var bool */
    public $noInteraction = false;

    /** @var bool */
    public $noPlugins = false;

    /** @var bool */
    public $ascii = false;

    /** @var bool */
    public $noAscii = false;

    public $requireOptions = [
        '--prefer-dist',
        //'--prefer-source',
        //'--no-progress',
        //'--no-update',
        //'--update-no-dev',
        //'--update-with-dependencies',
        //'--ignore-platform-reqs',
        //'--sort-packages',
        //'--classmap-authoritative',
    ];

    public $installOptions = [
        '--prefer-dist',
        '--optimize-autoloader',
        //'--prefer-source',
        //'--no-custom-installers',
        //'--no-autoloader',
        //'--no-scripts',
        //'--no-progress',
        //'--classmap-authoritative',
        //'--ignore-platform-reqs',
    ];

    public $updateOptions = [
        '--prefer-dist',
        '--prefer-stable',
        '--optimize-autoloader',
        //'--prefer-source',
        //'--prefer-lowest',
        //'--lock',
        //'--no-custom-installers',
        //'--no-autoloader',
        //'--no-scripts',
        //'--no-progress',
        //'--with-dependencies',
        //'--classmap-authoritative',
        //'--ignore-platform-reqs',
        //'--interactive',
        //'--root-reqs',
    ];

    public $selfupdateOptions = [
        '--stable',
        //'--preview',
        //'--snapshot',
        //'--clean-backups',
        //'--update-keys',
        //'--no-progress',
    ];

    public function init()
    {
        parent::init();

        if (empty($this->cwd)) {
            $this->cwd = $this->command->configReader->basePath;
        }
    }

    /**
     * @param array $defaultOptions
     * @param array $options
     * @return array
     */
    protected function formatOptions($defaultOptions = [], $options = [])
    {
        $result = $defaultOptions;

        if (!empty($options)) {
            foreach ($options as $option => $value) {
                if ($value === true) {
                    $result[] = $option;
                }
            }
        }

        return empty($result) ? null : implode(' ', $result);
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

            'require' => [
                '.description' => 'Adds required packages to your composer.json and installs them',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s require %s %s',
                        $this->composer,
                        $this->input->getArgument('arg1'),
                        $this->formatOptions($this->requireOptions, [
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],

            'install' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s install %s',
                        $this->composer,
                        $this->formatOptions($this->installOptions, [
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],
            'update' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s update %s',
                        $this->composer,
                        $this->formatOptions([], [
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],

            'install-dry' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (with `--dry-run`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s install %s',
                        $this->composer,
                        $this->formatOptions($this->installOptions, [
                            '--dry-run' => true,
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],
            'update-dry' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (with `--dry-run`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s update %s',
                        $this->composer,
                        $this->formatOptions($this->updateOptions, [
                            '--dry-run' => true,
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],

            'install-prod' => [
                '.description' => 'Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json (with `--no-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s install %s',
                        $this->composer,
                        $this->formatOptions($this->installOptions, [
                            '--no-dev' => true,
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],
            'update-prod' => [
                '.description' => 'Updates your dependencies to the latest version according to composer.json, and updates the composer.lock file (with `--no-dev`)',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s update %s',
                        $this->composer,
                        $this->formatOptions($this->updateOptions, [
                            '--no-dev' => true,
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],

            'self-update' => [
                '.description' => 'Updates composer.phar to the latest version',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s selfupdate %s',
                        $this->composer,
                        $this->formatOptions($this->selfupdateOptions, [
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],
            'selfupdate' => [
                '.description' => 'Updates composer.phar to the latest version (alias for `self-update`)',
                '.depends' => ['*/self-update'],
            ],

            'rollback' => [
                '.description' => 'Revert to an older installation of composer',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'cwd' => $this->cwd,
                    'commandline' => sprintf(
                        '%s selfupdate %s',
                        $this->composer,
                        $this->formatOptions($this->selfupdateOptions, [
                            '--rollback' => true,
                            '--no-interaction' => $this->noInteraction,
                            '--no-plugin' => $this->noPlugins,
                            '--ascii' => $this->ascii,
                            '--no-ascii' => $this->noAscii,
                            '--profile' => $this->profile,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ])
                    ),
                ],
            ],
            'revert' => [
                '.description' => 'Revert to an older installation of composer (alias for `rollback`)',
                '.depends' => ['*/rollback'],
            ],
        ];
    }
}