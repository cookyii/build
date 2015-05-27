<?php

return [
    // ./build default
    'default' => [
        'class' => cookyii\build\tasks\EchoTask::className(),
        'description' => 'Run default task',
        'message' => 'Executing default task...',
    ],

    'build' => [
        // ./build build/prod
        'prod' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Run production build',
            'message' => 'Executing production build...',
        ],

        // ./build build/dev
        'dev' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Run dev build',
            'message' => 'Executing dev build...',
        ],
    ],
];