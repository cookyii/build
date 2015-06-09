<?php
/**
 * build-loop.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

return [
    'default' => [
        '.description' => 'Default build',
        '.depends' => ['build'],
    ],

    'build' => [
        '.description' => 'Build project with demo environment',
        '.depends' => ['instruction/first'],
    ],

    'instruction' => [
        'first' => [
            '.description' => 'Install all depending for development environment (with `require-dev`)',
            '.depends' => ['instruction/second'],
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Execute first instruction',
            ],
        ],
        'second' => [
            '.description' => 'Update all depending for development environment (with `require-dev`)',
            '.depends' => ['instruction/first'],
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Execute second instruction',
            ],
        ],
    ],
];