MapTask
=======

**\cookyii\build\tasks\MapTask**

Задача выводит карту всех доступных задач.

Reference
---------

Класс `MapTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build map
    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => '\cookyii\build\tasks\MapTask',
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md