SelfTask
========

[**\cookyii\build\tasks\SelfTask**][]

Задача выполняет различные операции `cookyii/build`.

Reference
---------

Класс `SelfTask` наследует все атрибуты и методы класса [`AbstractCompositeTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `composer` | `string` | Путь к исполняемому файлу `composer.phar`. |
| `cwd` | `string` | Путь директории, в которой будут выполняться команды. |

Примеры конфигурации
--------------------
```php
[
    // ./build self
    // ./build self/update
    'self' => [
        '.description' => 'Internal tasks',
        '.task' => [
            'class' => '\cookyii\build\tasks\SelfTask',
            'composer' => '../composer.phar',
        ],
    ],
],
```

Композитная задача
------------------

Задача `SelfTask` является композитной задачей. То есть предоставляет возможность исполнять дополнительные команды.
Полный reference доступных задач Вы можете увидеть в результате выполнения задачи [`MapTask`][]

**Доступные задачи**

```bash
#Задача показывает карту доступных команд в текущем пространстве имён.
./build self[/default]

#Задача обновляет пакет `cookyii/build`.
./build self/update
```

[**\cookyii\build\tasks\SelfTask**]: https://github.com/cookyii/build/blob/master/tasks/SelfTask.php
[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`MapTask`]: 03-reference-task-map.md