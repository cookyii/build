FileExistsTask
==============

**\cookyii\build\tasks\FileExistsTask**

Задача проверяет существование файла.

Reference
---------

Класс `FileExistsTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `filename` | `string` | Путь к файлу, который необходимо проверить. |
| `message` | `string|null` | Сообщение об ошибке, в случае если файла не существует. |

Примеры конфигурации
--------------------
```php
[
    // ./build check-config
    'check-config' => [
        '.description' => 'Check application config',
        '.task' => [
            'class' => '\cookyii\build\tasks\FileExistsTask',
            'filename' => __DIR__ . '/config/main-local.php',
            'message' => 'Application configuration not exists.',            
        ],
    ],
    
    // ./build check-lock
    'check-lock' => [
        '.description' => 'Check lock file',
        '.task' => [
            'class' => '\cookyii\build\tasks\FileExistsTask',
            'filename' => __DIR__ . '/runtime/.lock',
            'message' => 'Application locked.',
        ],
    ],
],
```

[`AbstractTask`]: 03-reference-abstract-task.md