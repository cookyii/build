<?php
/**
 * build.php
 * @author Revin Roman http://phptime.ru
 */

use cookyii\build\commands\BuildCommand;

return [
    '.events' => [
        'subscribers' => [
            'cookyii\build\examples\ExampleEventSubscriber',
        ],
        'listeners' => [
            BuildCommand::EVENT_BEFORE_CREATE_TASK_OBJECT => ['cookyii\build\examples\ExampleEventListener', 'onBeforeCreateTaskObject'],
            BuildCommand::EVENT_AFTER_CREATE_TASK_OBJECT => ['cookyii\build\examples\ExampleEventListener', 'onAfterCreateTaskObject'],
            BuildCommand::EVENT_BEFORE_EXECUTE_TASK => ['cookyii\build\examples\ExampleEventListener', 'onBeforeExecuteTask'],
            BuildCommand::EVENT_AFTER_EXECUTE_TASK => ['cookyii\build\examples\ExampleEventListener', 'onAfterExecuteTask'],
        ],
    ],

    'map' => [
        'class' => 'cookyii\build\tasks\MapTask',
        'description' => 'Show map of all tasks in current build config',
    ],

    'default' => [
        'depends' => ['build/dev'],
        'description' => 'Default build',
    ],

    'runtime' => [
        'class' => 'cookyii\build\tasks\LockTask',
        'description' => 'Show map of task runtime/*',
        'lockFile' => 'runtime/runtime.lock',
    ],

    'build' => [
        'prod' => [
            'depends' => ['environment/check', 'environment/init/production', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with production environment',
        ],
        'demo' => [
            'depends' => ['environment/check', 'environment/init/demo', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with demo environment',
        ],
        'dev' => [
            'depends' => ['environment/check', 'environment/init', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with developer environment',
        ],
    ],

    'clear' => [
        'depends' => ['clear/assets', 'clear/vendor', 'clear/node'],
        'description' => 'Delete all temporary files and remove installed packages',
        'assets' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'description' => 'Remove all assets',
            'deleteDir' => false,
            'fileSets' => [
                [
                    'dir' => 'assets/css',
                    'exclude' => ['.gitignore'],
                ]
            ],
        ],
        'vendor' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'description' => 'Remove all the packages in the directory `vendor`',
            'deleteDir' => false,
            'fileSets' => [
                [
                    'dir' => 'vendor',
                    'exclude' => ['.gitignore'],
                ]
            ],
        ],
        'node' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'description' => 'Remove all the packages in the directory `node_modules` and remove the directory `node_modules`',
            'deleteDir' => true,
            'fileSets' => ['node_modules'],
        ],
        'all' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'description' => 'Delete all temporary files and remove installed packages (alternative)',
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

    'environment' => [
        'check' => [
            'class' => 'cookyii\build\tasks\FileExistsTask',
            'description' => 'Check file exists `.env.php`',
            'filename' => '.env.php',
            'message' => 'Внимание!' . "\n"
                . 'Необходимо заполнить параметры окружения' . "\n"
                . 'в файле %s' . "\n"
                . 'Шаблон в файле .environment.example.php',
        ],
        'init' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'description' => 'Initialize a new environment (manual selection)',
            'commandline' => 'php ./bin/init',
            'production' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'description' => 'Initialize a new environment (selected Production)',
                'commandline' => './bin/init --env=Production --force',
            ],
            'demo' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'description' => 'Initialize a new environment (selected Demo)',
                'commandline' => './bin/init --env=Demo --force',
            ],
        ],
    ],

    'composer' => [
        'class' => 'cookyii\build\tasks\ComposerTask',
        'description' => 'Install all depending composer for development environment (with `required-dev`)',
        'composer' => '../../composer.phar',
//        'defaultTask' => 'install-dev',
    ],

    'npm' => [
        'class' => 'cookyii\build\tasks\CommandTask',
        'description' => 'Install all npm and bower dependencies',
        'commandline' => 'npm install',
    ],

    'less' => [
        'depends' => ['less/frontend', 'less/backend'],
        'description' => 'Compile all less styles',
        'frontend' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'description' => 'Compile all less styles for frontend application',
            'commandline' => [
                './node_modules/.bin/lessc --source-map-map-inline assets/less/styles.less > assets/css/styles-raw.css',
                './node_modules/.bin/autoprefixer assets/css/styles-raw.css -o assets/css/styles.css',
                './node_modules/.bin/csso -i assets/css/styles.css -o assets/css/styles-o.css',
            ],
        ],
        'backend' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'description' => 'Compile all less styles for backend application',
            'commandline' => [
                './node_modules/.bin/lessc --source-map-map-inline assets/less/styles.less > assets/css/styles-raw.css',
                './node_modules/.bin/autoprefixer assets/css/styles-raw.css -o assets/css/styles.css',
                './node_modules/.bin/csso -i assets/css/styles.css -o assets/css/styles-o.css',
            ],
        ],
    ],

    'migrate' => [
        'class' => 'cookyii\build\tasks\EchoTask',
        'description' => 'Run database migration',
        'message' => 'Executing migrations for database...',
    ],
];