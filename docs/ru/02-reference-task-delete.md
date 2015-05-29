DeleteTask
==========

**\cookyii\build\tasks\DeleteTask**

задача удаляет файлы.

Reference
---------

Класс `DeleteTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `fileSets` | `array` | Массив, описывающий правила поиска файлов для удаления. |
| `deleteDir` | `boolean` | Если `true`, то будет совершена попытка удалить саму директорию (если она не пустая, произойдет ошибка). |

Примеры конфигурации
--------------------
```php
[
    // ./build clear
    'clear' => [
        'class' => '\cookyii\build\tasks\DeleteTask',
        'description' => 'Clear app',
        'deleteDir' => false,
        'fileSets' => [
            [
                'dir' => __DIR__ . '/runtime/logs',
                'exclude' => ['payments-*.log'],
            ],
            [
                'dir' => __DIR__ . '/runtime/debug',
                'exclude' => [],
            ],
        ],
    ],
    
    // ./build remove-all-packages
    'remove-all-packages' => [
        'class' => '\cookyii\build\tasks\DeleteTask',
        'description' => 'Remove all packages',
        'deleteDir' => true,
        'fileSets' => [
            [
                'dir' => __DIR__ . '/vendor',
                'exclude' => ['payments-*.log'],
            ],
            [
                'dir' => __DIR__ . '/node-modules',
                'exclude' => [],
            ],
        ],
    ],
],
```

[`AbstractTask`]: 02-reference-abstract-task.md