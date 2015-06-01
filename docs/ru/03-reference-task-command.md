CommandTask
===========

**\cookyii\build\tasks\CommandTask**

Задача выполняет произвольную программу в командной строке (cli command).

Reference
---------

Класс `CommandTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `commandline` | `string|array` | Одна команда или массив команд, которые необходимо выполнить в cli. |
| `cwd` | `string|null` | Путь директории, в которой необходимо выполнить команду. |

Примеры конфигурации
--------------------
```php
[
    // ./build install
    'install' => [
        '.description' => 'Run `make install` in project folder',
        '.task' => [
            'class' => '\cookyii\build\tasks\CommandTask',
            'commandline' => 'make install',
            'cwd' => '/var/www/project',
        ],
    ],
    
    // ./build npm
    'npm' => [
        '.description' => 'Install node.js packages',
        '.task' => [
            'class' => '\cookyii\build\tasks\CommandTask',
            'commandline' => 'npm install',
            'cwd' => __DIR__,
        ],
    ],
],
```

[`AbstractTask`]: 03-reference-abstract-task.md