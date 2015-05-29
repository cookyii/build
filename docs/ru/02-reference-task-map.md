MapTask
=======

**\cookyii\build\tasks\MapTask**

задача выводит карту всех доступных задач.

Reference
---------

Класс `MapTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build map
    'map' => [
        'class' => '\cookyii\build\tasks\MapTask',
        'description' => 'Show map of all tasks in current build config',
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md