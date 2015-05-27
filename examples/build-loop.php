<?php
/**
 * build-loop.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'default' => [
        'depends' => ['build'],
        'description' => 'Default build',
    ],

    'build' => [
        'depends' => ['instruction/first'],
        'description' => 'Build project with demo environment',
    ],

    'instruction' => [
        'first' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Install all depending for development environment (with `require-dev`)',
            'message' => 'Execute first instruction',
            'depends' => ['instruction/second'],
        ],
        'second' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Update all depending for development environment (with `require-dev`)',
            'message' => 'Execute second instruction',
            'depends' => ['instruction/first'],
        ],
    ],
];