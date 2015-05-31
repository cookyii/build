ComposerTask
============

**\cookyii\build\tasks\ComposerTask**

Задача выполняет различные операции composer.

Reference
---------

Класс `ComposerTask` наследует все атрибуты и методы класса [`AbstractCompositeTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `composer` | `string` | Путь к исполняемому файлу `composer.phar`. |

Примеры конфигурации
--------------------
```php
[
    // ./build composer/install-dev
    // ./build composer/install
    // ./build composer/update-dev
    // ./build composer/update
    // ./build composer/selfupdate
    'composer' => [
        '.description' => 'Install all depending for development environment (with `require-dev`)',
        '.task' => [
            'class' => '\cookyii\build\tasks\ComposerTask',
            'composer' => '../composer.phar',
        ],
    ],
],
```

Композитная задача
------------------

Задача `ComposerTask` является композитной задачей. То есть предоставляет возможность исполнять дополнительные команды.
Полный reference доступных задач Вы можете увидеть в результате выполнения задачи [`MapTask`][]

[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`MapTask`]: 03-reference-task-map.md
