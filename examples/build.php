<?php
/**
 * build.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

use cookyii\build\commands\BuildCommand;

return [
    '.events' => [
        'subscribers' => [
            'cookyii\build\examples\ExampleEventSubscriber',
        ],
        'listeners' => [
            BuildCommand::EVENT_BEFORE_CONFIGURE_TASK => ['cookyii\build\examples\ExampleEventListener', 'onBeforeConfigureTask'],
            BuildCommand::EVENT_AFTER_CONFIGURE_TASK => ['cookyii\build\examples\ExampleEventListener', 'onAfterConfigureTask'],
            BuildCommand::EVENT_BEFORE_RUN_TASK => ['cookyii\build\examples\ExampleEventListener', 'onBeforeRunTask'],
            BuildCommand::EVENT_AFTER_RUN_TASK => ['cookyii\build\examples\ExampleEventListener', 'onAfterRunTask'],
        ],
    ],

    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],

    'default' => [
        '.description' => 'Default build',
        '.depends' => ['build/dev'],
    ],

    'runtime' => [
        '.description' => 'Show map of task runtime/*',
        '.task' => [
            'class' => 'cookyii\build\tasks\LockTask',
            'name' => 'runtime',
            'state' => 'runtime-lock',
        ],
    ],

    'build' => [
        'prod' => [
            '.description' => 'Build project with production environment',
            '.depends' => ['environment/check', 'environment/init/production', 'composer', 'npm', 'less', 'migrate'],
        ],
        'demo' => [
            '.description' => 'Build project with demo environment',
            '.depends' => ['environment/check', 'environment/init/demo', 'composer', 'npm', 'less', 'migrate'],
        ],
        'dev' => [
            '.description' => 'Build project with developer environment',
            '.depends' => ['environment/check', 'environment/init', 'composer', 'npm', 'less', 'migrate'],
        ],
    ],

    'clear' => [
        '.description' => 'Delete all temporary files and remove installed packages',
        '.depends' => ['*/assets', '*/vendor', '*/node'],
        'assets' => [
            '.description' => 'Remove all assets',
            '.task' => [
                'class' => 'cookyii\build\tasks\DeleteTask',
                'deleteDir' => false,
                'fileSets' => [
                    [
                        'dir' => 'assets/css',
                        'exclude' => ['.gitignore'],
                    ]
                ],
            ],
        ],
        'vendor' => [
            '.description' => 'Remove all the packages in the directory `vendor`',
            '.task' => [
                'class' => 'cookyii\build\tasks\DeleteTask',
                'deleteDir' => false,
                'fileSets' => [
                    [
                        'dir' => 'vendor',
                        'exclude' => ['.gitignore'],
                    ]
                ],
            ],
        ],
        'node' => [
            '.description' => 'Remove all the packages in the directory `node_modules` and remove the directory `node_modules`',
            '.task' => [
                'class' => 'cookyii\build\tasks\DeleteTask',
                'deleteDir' => true,
                'fileSets' => ['node_modules'],
            ],
        ],
        'all' => [
            '.description' => 'Delete all temporary files and remove installed packages (alternative)',
            '.task' => [
                'class' => 'cookyii\build\tasks\DeleteTask',
                'fileSets' => [
                    [
                        'dir' => 'assets/css',
                        'exclude' => ['.gitignore'],
                    ], [
                        'dir' => 'vendor',
                        'exclude' => ['.gitignore'],
                    ], [
                        'dir' => 'node_modules',
                        'exclude' => [],
                    ],
                ],
            ],
        ],
    ],

    'environment' => [
        'check' => [
            '.description' => 'Check file exists `.env.php`',
            '.task' => [
                'class' => 'cookyii\build\tasks\FileExistsTask',
                'filename' => '.env.php',
                'message' => 'Warning!' . "\n"
                    . 'It is necessary to fill in the parameters environment' . "\n"
                    . 'in file %s' . "\n"
                    . 'Example in `.environment.example.php`',
            ],
        ],
        'init' => [
            '.description' => 'Initialize a new environment (manual selection)',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => 'php ./bin/init',
            ],
            'production' => [
                '.description' => 'Initialize a new environment (selected Production)',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CommandTask',
                    'commandline' => './bin/init --env=Production --force',
                ],
            ],
            'demo' => [
                '.description' => 'Initialize a new environment (selected Demo)',
                '.task' => [
                    'class' => 'cookyii\build\tasks\CommandTask',
                    'commandline' => './bin/init --env=Demo --force',
                ],
            ],
        ],
        'chown' => [
            '.description' => 'Change owner',
            '.task' => [
                'class' => 'cookyii\build\tasks\ChownTask',
                'user' => 'www-data',
                'filename' => 'runtime/chown.test',
                'fileSets' => [
                    ['dir' => 'runtime/chown'],
                ],
            ],
        ],
        'chmod' => [
            '.description' => 'Change file mode',
            '.task' => [
                'class' => 'cookyii\build\tasks\ChmodTask',
                'dirMode' => 0775,
                'fileMode' => 0664,
                'fileSets' => [
                    ['dir' => 'runtime'],
                ],
            ],
        ],
        'username' => [
            '.description' => 'Fill you name',
            '.task' => [
                'class' => 'cookyii\build\tasks\InputTask',
                'state' => 'username',
                'message' => 'Your name:',
            ],
        ],
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'composer' => '../../composer.phar',
            'defaultTask' => 'install-dev',
        ],
    ],

    'npm' => [
        '.description' => 'Install all npm and bower dependencies',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => 'npm install',
        ],
    ],

    'less' => [
        '.description' => 'Compile all less styles',
        '.depends' => ['*/frontend', '*/backend'],
        'frontend' => [
            '.description' => 'Compile all less styles for frontend application',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => [
                    './node_modules/.bin/lessc --source-map-map-inline assets/less/styles.less > assets/css/styles-raw.css',
                    './node_modules/.bin/autoprefixer assets/css/styles-raw.css -o assets/css/styles.css',
                    './node_modules/.bin/csso -i assets/css/styles.css -o assets/css/styles-o.css',
                ],
            ],
        ],
        'backend' => [
            '.description' => 'Compile all less styles for backend application',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => [
                    './node_modules/.bin/lessc --source-map-map-inline assets/less/styles.less > assets/css/styles-raw.css',
                    './node_modules/.bin/autoprefixer assets/css/styles-raw.css -o assets/css/styles.css',
                    './node_modules/.bin/csso -i assets/css/styles.css -o assets/css/styles-o.css',
                ],
            ],
        ],
    ],

    'migrate' => [
        '.description' => 'Run database migration',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Executing migrations for database...',
        ],
    ],
];