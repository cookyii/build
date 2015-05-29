EchoTask
========

задача выводит произвольное сообщение.

Reference
---------

Класс `EchoTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build message
    'datetime' => [
        'class' => '\cookyii\build\tasks\EchoTask',
        'description' => 'Show some message',
        'message' => 'Hello world!',
    ],
    
    // ./build datetime
    'datetime' => [
        'class' => '\cookyii\build\tasks\EchoTask',
        'description' => 'Show datetime',
        'message' => 'Now ' . date('d.m.Y H:i'),
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md