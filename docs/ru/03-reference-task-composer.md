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

```bash
#Задача показывает карту доступных команд в текущем пространстве имён.
./build composer[/default]

#Задача устанавливает пакет `vendor/pacakage-name` версии `version` в текущем приложении.
./build composer/require vendor/pacakage-name:version

#Задача устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`. Если файла нет, все зависимости будут установлены через компанду `composer/update-dev`.
./build composer/install-dev

#Эта задача как и предыдущая - устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`, но при этом игнорирует блок `require-dev` (для продакшена). Если файла нет, все зависимости будут установлены через компанду `composer/update`.
./build composer/install

#Задача обновляет все зависимые пакеты из файла `composer.json` до актуальных версий.
./build composer/update-dev

#Эта задача как и предыдущая - обновляет все зависимые пакеты из файла `composer.json` до актуальных версий, но при этом игнорирует блок `require-dev` (для продакшена).
./build composer/update

#Задача обновляет скрипт `composer.phar` до последней версии.
./build composer/self-update

#Задача обновляет скрипт `composer.phar` до последней версии (алиас для команды `composer/self-update`).
./build composer/selfupdate
```

[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`MapTask`]: 03-reference-task-map.md
