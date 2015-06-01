BlankTask
=========

[**\cookyii\build\tasks\BlankTask**](https://github.com/cookyii/build/blob/master/tasks/BlankTask.php)

Задача-заглушка, которая используется когда не указан класс задачи.

Reference
---------

Класс `BlankTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build map
    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => '\cookyii\build\tasks\BlankTask',
    ],
    
    // ./build nothing
    'nothing' => [
        '.description' => 'Nothing to do',
        // `.task` можно не указывать
    ],
],
```

[`AbstractTask`]: 03-reference-abstract-task.md