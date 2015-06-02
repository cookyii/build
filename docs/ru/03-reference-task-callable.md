CallableTask
============

[**\cookyii\build\tasks\CallableTask**][]

Задача выполняется произвольную php функцию (callable).

Reference
---------

Класс `CallableTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `handler` | `callable` | Анонимная функция или имя функции, заданное строковой переменной или массивом (например: `functionname`, `[$SomeObject, 'MethodName']`, `function(CallableTask $Task, ...$params) { }`), которую необходимо выполнить в рамках текущей задачи. |
| `params` | `array` | Параметры, которые будут дополнительно переданы в обработчик. |

Примеры конфигурации
--------------------
```php
[
    // ./build email
    'email' => [
        '.description' => 'Send email about new build',
        '.task' => [
            'class' => 'cookyii\build\tasks\CallableTask',
            'handler' => function (CallableTask $Task, $email, $subject) {
                mailto('email@localhost', 'New build', 'Hello, it\'s a new build.');
            },
            'params' => [$email, $subject],
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

[**\cookyii\build\tasks\CallableTask**]: https://github.com/cookyii/build/blob/master/tasks/CallableTask.php
[`AbstractTask`]: 03-reference-abstract-task.md