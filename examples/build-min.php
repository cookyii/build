<?php
/**
 * build-min.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

return [
    '.events' => [
        'subscribers' => [],
        'listeners' => [],
    ],

    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.class' => 'cookyii\build\tasks\MapTask',
    ],

    'default' => [
        '.description' => 'Default build',
        '.depends' => ['build'],
    ],

    'build' => [
        '.description' => 'Build project with demo environment',
        '.depends' => ['composer', 'migrate'],
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'defaultTask' => 'install-dev',
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