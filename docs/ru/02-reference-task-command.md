CommandTask
===========

**\cookyii\build\tasks\CommandTask**

задача выполняет произвольную программу в командной строке (cli command).

Reference
---------

Класс `CommandTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `commandline` | `string|array` | Одна команда или массик команд, которые необходимо выполнить в cli. |
| `cwd` | `string|null` | Путь директории, в которой необходимо выполнить команду. |
| `callback` | `callable` | Анонимная функция или имя функции, заданное строковой переменной или массивом (например: `functionname`, `[$SomeObject, 'MethodName']`, `function(CommandTask $Task, $result){}`), которую необходимо выполнить после отработки программы. |

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
            'callback' => function (CommandTask $Task, $result) {
                save_result_to_file($result);
            },
        ],
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md