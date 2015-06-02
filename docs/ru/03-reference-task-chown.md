ChownTask
=========

[**\cookyii\build\tasks\ChownTask**](https://github.com/cookyii/build/blob/master/tasks/ChownTask.php)

Задача изменяет владельца файла (chown).

Reference
---------

Класс `ChownTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `filename` | `string|array` | Путь к файлу, которому необходимо изменить права доступа. |
| `fileSets` | `string|null` | Массив, описывающий правила поиска файлов для изменения прав доступа. |
| `user` | `string` | Имя пользователя нового владельца файла. |
| `group` | `string` | Группа пользователя нового владельца файла (по умолчанию равно имени пользователя). |

Примеры конфигурации
--------------------
```php
[
    // ./build chown
    'chown' => [
        '.description' => 'Set chown',
        '.task' => [
            'class' => '\cookyii\build\tasks\ChownTask',
            'user' => 'www-data',
            'group' => 'www-data',
            'fileSets' => [
                ['dir' => __DIR__ . '/runtime']
            ],
        ],
    ],
],
```

[`AbstractTask`]: 03-reference-abstract-task.md