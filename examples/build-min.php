<?php
/**
 * build-min.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'map' => [
        'class' => cookyii\build\tasks\MapTask::className(),
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
        'depends' => ['composer/install-dev'],
        'description' => 'Install all depending composer for development environment (with `required-dev`)',
        'install' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Install all depending for development environment (with `require-dev`)',
            'commandline' => 'composer install --prefer-dist',
        ],
        'update' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Update all depending for development environment (with `require-dev`)',
            'commandline' => 'composer update --prefer-dist',
        ],
        'self-update' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Update composer script',
            'commandline' => 'composer self-update',
        ],
    ],

    'migrate' => [
        'class' => cookyii\build\tasks\EchoTask::className(),
        'description' => 'Run database migration',
        'message' => 'Executing migrations for database...',
    ],
];