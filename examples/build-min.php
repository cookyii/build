<?php
/**
 * build-min.php
 * @author Revin Roman http://phptime.ru
 */

return [
    '.events' => [
        'subscribers' => [],
        'listeners' => [],
    ],

    'map' => [
        'class' => 'cookyii\build\tasks\MapTask',
        'description' => 'Show map of all tasks in current build config',
    ],

    'default' => [
        'depends' => ['build'],
        'description' => 'Default build',
    ],

    'build' => [
        'depends' => ['composer', 'migrate'],
        'description' => 'Build project with demo environment',
    ],

    'composer' => [
        'class' => 'cookyii\build\tasks\ComposerTask',
        'description' => 'Install all depending composer for development environment (with `required-dev`)',
        'defaultTask' => 'install-dev',
    ],

    'migrate' => [
        'class' => 'cookyii\build\tasks\EchoTask',
        'description' => 'Run database migration',
        'message' => 'Executing migrations for database...',
    ],
];