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
    public $preferDist = true;

    /** @var bool */
    public $preferStable = true;

    /** @var bool */
    public $optimizeAutoloader = true;

    /** @var bool */
    public $noInteraction = false;

    public function init()
    {
        parent::init();

        if (empty($this->cwd)) {
            $this->cwd = $this->command->configReader->basePath;
        }
    }

    /**
     * @param array $options
     * @return array
     */
    protected function formatOptions($options = [])
    {
        $result = [];

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
                        $this->formatOptions([
                            '--prefer-dist' => $this->preferDist,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--prefer-dist' => $this->preferDist,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--prefer-dist' => $this->preferDist,
                            '--prefer-stable' => $this->preferStable,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--dry-run' => true,
                            '--prefer-dist' => $this->preferDist,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--dry-run' => true,
                            '--prefer-dist' => $this->preferDist,
                            '--prefer-stable' => $this->preferStable,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--no-dev' => true,
                            '--prefer-dist' => $this->preferDist,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--no-dev' => true,
                            '--prefer-dist' => $this->preferDist,
                            '--prefer-stable' => $this->preferStable,
                            '--optimize-autoloader' => $this->optimizeAutoloader,
                            '--no-interaction' => $this->noInteraction,
                            '--quiet' => $this->quiet,
                            '--verbose' => $this->verbose,
                        ], ['--no-dev'])
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
                        $this->formatOptions([
                            '--no-interaction' => $this->noInteraction,
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
                        $this->formatOptions([
                            '--rollback' => true,
                            '--no-interaction' => $this->noInteraction,
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