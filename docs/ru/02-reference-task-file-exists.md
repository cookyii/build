FileExistsTask
==============

**\cookyii\build\tasks\FileExistsTask**

задача проверяет существование файла.

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
        'class' => '\cookyii\build\tasks\FileExistsTask',
        'description' => 'Check application config',
        'filename' => __DIR__ . '/config/mail-local.php',
        'message' => 'Application configuration not exists.',
    ],
    
    // ./build check-lock
    'check-lock' => [
        'class' => '\cookyii\build\tasks\FileExistsTask',
        'description' => 'Check lock file',
        'filename' => __DIR__ . '/runtime/.lock',
        'message' => 'Application locked.',
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md