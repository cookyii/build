ReplacementTask
===============

[**\cookyii\build\tasks\ReplacementTask**](https://github.com/cookyii/build/blob/master/tasks/ReplacementTask.php)

Задача заменяет определённые подстроки в файле.

Reference
---------

Класс `ReplacementTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `filename` | `string` | Путь к файлу, в котором необходимо произвести замену. |
| `placeholders` | `array` | Массив для замены. Ключи массива - подстроки для происка, значения - value замены. |

Примеры конфигурации
--------------------
```php
[
    // ./build replace-placeholders
    'replace-placeholders' => [
        '.description' => 'Replace placeholders in config',
        '.task' => [
            'class' => '\cookyii\build\tasks\ReplacementTask',
            'filename' => __DIR__ . '/config/main.php',
            'placeholders' => [
                '###COOKIE_KEY###' => uniqid(rand()),
                '###FACEBOOK_SECURE_KEY###' => sha1(microtime(true))
            ],            
        ],
    ],
],
```

[`AbstractTask`]: 03-reference-abstract-task.md