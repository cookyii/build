Cookyii/Build
=============

Cookyii/build is a simple PHP build tool built on [Symfony Console][].

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
```

Run build
---------

```sh
$ ./vendor/bin/build # start build from `default` task
$ ./vendor/bin/build migrate # start build from `migrate` task
$ ./vendor/bin/build -c ./project/build-conf.php # start build with specify non default conf file
```

Documentation
-------------

- [Installing][]
- [Usage][]

[Symfony Console]: http://symfony.com/doc/current/components/console/introduction.html
[Installing]: docs/ru/00-installing.md
[Usage]: docs/ru/01-usage.md