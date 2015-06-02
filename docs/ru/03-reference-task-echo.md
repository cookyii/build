EchoTask
========

[**\cookyii\build\tasks\EchoTask**](https://github.com/cookyii/build/blob/master/tasks/EchoTask.php)

Задача выводит произвольное сообщение.

Reference
---------

Класс `EchoTask` наследует все атрибуты и методы класса [`AbstractTask`][].

Примеры конфигурации
--------------------
```php
[
    // ./build message
    'message' => [
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

[`AbstractTask`]: 03-reference-abstract-task.md