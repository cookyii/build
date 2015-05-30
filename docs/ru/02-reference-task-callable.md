CallableTask
============

**\cookyii\build\tasks\CallableTask**

Задача выполняется произвольную php функцию (callable).

Reference
---------

Класс `CallableTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `handler` | `callable` | Анонимная функция или имя функции, заданное строковой переменной или массивом (например: `functionname`, `[$SomeObject, 'MethodName']`, `function(CallableTask $Task){}`), которую необходимо выполнить в рамках текущей задачи. |

Примеры конфигурации
--------------------
```php
[
    // ./build email
    'email' => [
        '.description' => 'Send email about new build',
        '.task' => [
            'class' => 'cookyii\build\tasks\CallableTask',
            'handler' => function (CallableTask $Task) {
                mailto('email@localhost', 'New build', 'Hello, it\'s a new build.');
            },
        ],
    ],
    
    // ./build some-static
    'some-static' => [
        '.description' => 'Call \app\Command::staticMethod()',
        '.task' => [
            'class' => '\cookyii\build\tasks\CallableTask',
            'handler' => ['\app\Command', 'staticMethod'],
        ],
    ],
    
    // ./build some-method
    'some-method' => [
        '.description' => 'Call $SomeObject->someMethod()',
        '.task' => [
            'class' => '\cookyii\build\tasks\CallableTask',
            'handler' => [$SomeObject, 'someMethod'],
        ],
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md
