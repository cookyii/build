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
    [
        'class' => '\cookyii\build\tasks\CallableTask',
        'description' => 'Send email about new build',
        'handler' => function (CallableTask $Task) {
            mailto('email@localhost', 'New build', 'Hello, it\'s a new build.');
        },
    ],
    [
        'class' => '\cookyii\build\tasks\CallableTask',
        'description' => 'Call \app\Command::staticMethod()',
        'handler' => ['\app\Command', 'staticMethod'],
    ],
    [
        'class' => '\cookyii\build\tasks\CallableTask',
        'description' => 'Call $SomeObject->someMethod()',
        'handler' => [$SomeObject, 'someMethod'],
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md
