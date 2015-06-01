LockTask
========

[**\cookyii\build\tasks\LockTask**](https://github.com/cookyii/build/blob/master/tasks/LockTask.php)

Задача управляет блокировкой файла.

Reference
---------

Класс `LockTask` наследует все атрибуты и методы класса [`AbstractCompositeTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `name` | `string` | Идентификатор блокировки. |
| `lockPath` | `string` | Путь к директории, где будет создан файл блокировки. |

Примеры конфигурации
--------------------
```php
[
    // ./build lock/lock
    // ./build lock/release
    'lock' => [
        '.description' => 'Install all depending for development environment (with `require-dev`)',
        '.task' => [
            'class' => '\cookyii\build\tasks\LockTask',
            'name' => 'tempname',
        ],
    ],
],
```

Композитная задача
------------------

Задача `LockTask` является композитной задачей. То есть предоставляет возможность исполнять дополнительные команды.
Полный reference доступных задач Вы можете увидеть в результате выполнения задачи [`MapTask`][]

**Доступные задачи**

```bash
#Задача показывает карту доступных команд в текущем пространстве имён.
./build lock[/default]

#Задача устанавливает блокировку.
./build lock/lock

#Задача снимает блокировку.
./build lock/release
```

[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`MapTask`]: 03-reference-task-map.md
