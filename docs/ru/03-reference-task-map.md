MapTask
=======

[**\cookyii\build\tasks\MapTask**](https://github.com/cookyii/build/blob/master/tasks/MapTask.php)

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

[`AbstractTask`]: 03-reference-abstract-task.md