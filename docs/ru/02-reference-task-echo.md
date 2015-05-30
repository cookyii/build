EchoTask
========

Задача выводит произвольное сообщение.

Reference
---------

Класс `EchoTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build message
    'datetime' => [
        '.description' => 'Show some message',
        '.task' => [
            'class' => '\cookyii\build\tasks\EchoTask',
            'message' => 'Hello world!',
        ],
    ],
    
    // ./build datetime
    'datetime' => [
        '.description' => 'Show datetime',
        '.task' => [
            'class' => '\cookyii\build\tasks\EchoTask',
            'message' => 'Now ' . date('d.m.Y H:i'),
        ],
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md