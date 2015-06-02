InputTask
=========

[**\cookyii\build\tasks\InputTask**][]

Задаче предоставляет возможность ввести пользовательские данные путём ввода информации (prompt).

Reference
---------

Класс `InputTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `state` | `string` | Название ключа переменной, в которой будет сохранен ввод пользователя. |
| `message` | `string|null` | Сообщение, которое будет сопровождать строку ввода (prompt). |

Примеры конфигурации
--------------------
```php
[
    'fill' => [
        // ./build fill/username
        'username' => [
            '.description' => 'Fill username',
            '.task' => [
                'class' => '\cookyii\build\tasks\InputTask',
                'state' => 'username',
                'message' => 'Your username:',            
            ],
        ],
        
        // ./build fill/email
        'email' => [
            '.description' => 'Fill email',
            '.task' => [
                'class' => '\cookyii\build\tasks\InputTask',
                'state' => 'email',
                'message' => 'Your email:',            
            ],
        ],
    ],
],
```

[**\cookyii\build\tasks\InputTask**]: https://github.com/cookyii/build/blob/master/tasks/InputTask.php
[`AbstractTask`]: 03-reference-abstract-task.md