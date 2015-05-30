<?php
/**
 * base.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'blank' => [
        '.description' => 'Nothing',
    ],

    'callable' => [
        '.description' => 'Execute CallableTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\CallableTask',
            'handler' => function (cookyii\build\tasks\CallableTask $Task) {
                echo 'Callable task executed.';

                return true;
            }
        ],
        'failure' => [
            '.description' => 'Execute CallableTask with failure',
            '.task' => [
                'class' => 'cookyii\build\tasks\CallableTask',
                'handler' => function (cookyii\build\tasks\CallableTask $Task) {
                    echo 'Oh no...';

                    return false;
                }
            ],
        ],
    ],

    'command' => [
        '.description' => 'Execute CommandTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => 'ls',
            'cwd' => realpath(__DIR__ . '/..'),
        ],
    ],

    'echo' => [
        '.description' => 'Execute EchoTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Echo task executed.',
        ],
    ],

    'lock' => [
        '.description' => 'Execute LockTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\LockTask',
            'filename' => realpath(__DIR__ . '/../runtime/runtime.lock'),
        ],
    ],

    'map' => [
        '.description' => 'Execute MapTask',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],
];