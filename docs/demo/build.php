<?php

return [
    // ./build default
    'default' => [
        '.description' => 'Run default task',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Executing default task...',
        ],
    ],

    'build' => [
        // ./build build/prod
        'prod' => [
            '.description' => 'Run production build',
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Executing production build...',
            ],
        ],

        // ./build build/dev
        'dev' => [
            '.description' => 'Run dev build',
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Executing dev build...',
            ],
        ],
    ],
];