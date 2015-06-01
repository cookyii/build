ComposerTask
============

[**\cookyii\build\tasks\ComposerTask**](https://github.com/cookyii/build/blob/master/tasks/ComposerTask.php)

Задача выполняет различные операции composer.

Reference
---------

Класс `ComposerTask` наследует все атрибуты и методы класса [`AbstractCompositeTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `composer` | `string` | Путь к исполняемому файлу `composer.phar`. |

Примеры конфигурации
--------------------
```php
[
    // ./build composer
    // ./build composer/require
    // ./build composer/install-dev
    // ./build composer/install
    // ./build composer/update-dev
    // ./build composer/update
    // ./build composer/selfupdate
    'composer' => [
        '.description' => 'Install all depending for development environment (with `require-dev`)',
        '.task' => [
            'class' => '\cookyii\build\tasks\ComposerTask',
            'composer' => '../composer.phar',
        ],
    ],
],
```

Композитная задача
------------------

Задача `ComposerTask` является композитной задачей. То есть предоставляет возможность исполнять дополнительные команды.
Полный reference доступных задач Вы можете увидеть в результате выполнения задачи [`MapTask`][]

**Доступные задачи**

`./build composer[/default]`

Задача [`MapTask`][]. Показывает карту доступных команд в текущем пространстве имён.

`./build composer/require vendor/pacakage-name:version`

Задача [`CommandTask`][]. Устанавливает пакет `vendor/pacakage-name` версии `version` в текущем приложении.

`./build composer/install-dev`

Задача [`CommandTask`][]. Устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`. Если файла нет, все зависимости будут установлены через компанду `composer/update-dev`.

`./build composer/install`

Задача [`CommandTask`][]. Эта задача как и предыдущая - устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`, но при этом игнорирует блок `require-dev` (для продакшена). Если файла нет, все зависимости будут установлены через компанду `composer/update`.

`./build composer/update-dev`

Задача [`CommandTask`][]. Обновляет все зависимые пакеты из файла `composer.json` до актуальных версий.

`./build composer/update`

Задача [`CommandTask`][]. Эта задача как и предыдущая - обновляет все зависимые пакеты из файла `composer.json` до актуальных версий, но при этом игнорирует блок `require-dev` (для продакшена).

`./build composer/self-update`

Задача [`CommandTask`][]. Обновляет скрипт `composer.phar` до последней версии.

`./build composer/selfupdate`

Задача [`CommandTask`][]. Обновляет скрипт `composer.phar` до последней версии (алиас для команды `composer/self-update`).


[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`CommandTask`]: 03-reference-task-command.md
[`MapTask`]: 03-reference-task-map.md
