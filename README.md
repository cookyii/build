Cookyii/Build
=============

Cookyii/build is a simple PHP build tool for any projects.

Documentation
-------------

- [Installing (RU)][]
- [Configuration (RU)][]
- [Usage (RU)][]

Quick start
------------

**Installing**

[Composer][]

    $ composer require cookyii/build:dev-master
    
**Updating**

    $ ./build self/update
    
or [Composer][]

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
        
    'self' => [
        '.description' => 'Internal tasks',
        '.task' => [
            'class' => 'cookyii\build\tasks\SelfTask',
            'composer' => '../../composer.phar',
        ],
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'defaultTask' => 'install',
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

**Task reference**

* [`BlankTask`][] - empty task, which is used when a class is not specified.
* [`CallableTask`][] - task to execute php function (callable).
* [`ChmodTask`][] - task to change file mode (chmod).
* [`ChownTask`][] - task to change owner (chown).
* [`CommandTask`][] - task to execute programm on the command line (cli command).
* [`ComposerTask`][] - task to execute `composer` functions.
* [`DeleteTask`][] - task deletes files.
* [`EchoTask`][] - task displays custom message.
* [`FileExistsTask`][] - task checks for the existence of the file.
* [`InputTask`][] - prompt task.
* [`LockTask`][] - task of managing locking file.
* [`MapTask`][] - task displays a map of all available tasks.
* [`ReplacementTask`][] - task of replacing placeholders in file.
* [`SelfTask`][] - task with internal tasks `cookyii/build`.

[Composer]: http://getcomposer.org/
[Symfony Console]: http://symfony.com/doc/current/components/console/introduction.html
[Installing (RU)]: https://github.com/cookyii/build/blob/master/docs/ru/00-installing.md
[Configuration (RU)]: https://github.com/cookyii/build/blob/master/docs/ru/01-config.md
[Usage (RU)]: https://github.com/cookyii/build/blob/master/docs/ru/02-usage.md
[`BlankTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-blank.md
[`CallableTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-callable.md
[`ChmodTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-chmod.md
[`ChownTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-chown.md
[`CommandTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-command.md
[`ComposerTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-composer.md
[`DeleteTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-delete.md
[`EchoTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-echo.md
[`FileExistsTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-file-exists.md
[`InputTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-input.md
[`LockTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-lock.md
[`MapTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-map.md
[`ReplacementTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-replacement.md
[`SelfTask`]: https://github.com/cookyii/build/blob/master/docs/ru/03-reference-task-self.md
