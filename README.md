Cookyii/Build
=============

Cookyii/build is a simple PHP build tool built on [Symfony Console][].

Documentation
-------------

- [Installing (RU)][]
- [Usage (RU)][]
- [Configuration (RU)][]

Quick start
------------

**Installing**

[Composer][]

    $ composer require cookyii/build:dev-master

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
        '.description' => 'Build project with demo environment',
        '.depends' => ['composer'],
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'defaultTask' => 'install-dev',
        ],
    ],
];
```

**Usage (run build)**

```sh
$ ./vendor/bin/build # start build from `default` task
$ ./vendor/bin/build composer # start build from `composer` task
$ ./vendor/bin/build -c build.dev.php # start build with specified configuration file `build.dev.php`
```

[Composer]: http://getcomposer.org/
[Symfony Console]: http://symfony.com/doc/current/components/console/introduction.html
[Installing (RU)]: docs/ru/00-installing.md
[Usage (RU)]: docs/ru/01-usage.md
[Configuration (RU)]: docs/ru/02-config.md