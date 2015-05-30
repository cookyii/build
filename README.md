Cookyii/Build
=============

Cookyii/build is a simple PHP build tool built on [Symfony Console][].

Documentation
-------------

- [Installing][]
- [Usage][]

Quick start
------------

**Configuration**

In project path must be file `build.php` (It can be called whatever you like. The name `build.php` is taken by default.)

/var/www/my-project/build.php:
```php
<?php

return [
    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],

    'default' => [
        '.description' => 'Default build',
        '.depends' => ['build'],
    ],

    'build' => [
        '.description' => 'Build project with demo environment',
        '.depends' => ['composer', 'migrate'],
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'defaultTask' => 'install-dev',
        ],
    ],

    'migrate' => [
        '.description' => 'Run database migration',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Executing migrations for database...',
        ],
    ],
];
```

**Run build**

```sh
$ ./vendor/bin/build # start build from `default` task
$ ./vendor/bin/build migrate # start build from `migrate` task
$ ./vendor/bin/build -c ./project/build-conf.php # start build with specify non default conf file
```

[Symfony Console]: http://symfony.com/doc/current/components/console/introduction.html
[Installing]: docs/ru/00-installing.md
[Usage]: docs/ru/01-usage.md