DeleteTask
==========

**\cookyii\build\tasks\DeleteTask**

Задача удаляет файлы.

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
        '.description' => 'Clear app',
        '.task' => [
            'class' => '\cookyii\build\tasks\DeleteTask',
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
    ],
    
    // ./build remove-all-packages
    'remove-all-packages' => [
        '.description' => 'Remove all packages',
        '.task' => [
            'class' => '\cookyii\build\tasks\DeleteTask',
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
],
```

[`AbstractTask`]: 03-reference-abstract-task.md