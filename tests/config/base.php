<?php
/**
 * base.php
 * @author Revin Roman http://phptime.ru
 */

$base_path = realpath(__DIR__ . '/..');
$runtime_path = realpath($base_path . '/runtime');

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
            'cwd' => $base_path,
        ],
    ],

    'composer' => [
        '.description' => 'Execute ComposerTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'composer' => 'composer',
            'cwd' => $runtime_path,
            'quiet' => true,
        ],
    ],

    'echo' => [
        '.description' => 'Execute EchoTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Echo task executed.',
        ],
    ],

    'exists' => [
        '.description' => 'Execute FileExistsTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\FileExistsTask',
            'filename' => $runtime_path . '/non-exists.file',
        ],
    ],

    'lock' => [
        '.description' => 'Execute LockTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\LockTask',
            'name' => 'runtime',
            'checkState' => 'runtime-lock',
        ],
    ],

    'map' => [
        '.description' => 'Execute MapTask',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],

    'replacement' => [
        '.description' => 'Execute ReplacementTask',
        '.task' => [
            'class' => 'cookyii\build\tasks\ReplacementTask',
            'filename' => $runtime_path . '/replacement-target.log',
            'placeholders' => [
                '#KEY#' => sha1(microtime(true)),
            ],
        ],
    ],
];