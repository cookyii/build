Cookyii/Build
=============

Cookyii/build is a simple PHP build tool built on [Symfony Console](http://symfony.com/doc/current/components/console/index.html).

Build config
------------

In project path must be file `build.php` (It can be called whatever you like. The name `build.php` is taken by default.)

/var/www/my-project/build.php:
```php
<?php

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
```

```sh
$ bin/build # start build from `default` task
$ bin/build migrate # start build from `migrate` task
$ bin/build -c ./project/build-conf.php # start build with specify non default conf file
```

Documentation
-------------

- [Installing][docs/ru/00-installing.md]
- [Usage][docs/ru/01-usage.md]