ComposerTask
============

[**\cookyii\build\tasks\ComposerTask**][]

Задача выполняет различные операции `composer`.

Reference
---------

Класс `ComposerTask` наследует все атрибуты и методы класса [`AbstractCompositeTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `cwd` | `string` | Путь директории, в которой будут выполняться команды. |
| `composer` | `string` | Путь к исполняемому файлу `composer.phar`. |
| `preferDist` | `bool` | Если `true`, то в команду `composer` будет добавлена опция `--prefer-dist` (скачивать пакеты в виде дистрибутивов, если возможно). |
| `preferStable` | `bool` | Если `true`, то в команду `composer` будет добавлена опция `--prefer-stable` (скачивать пакеты только стабильных версий, если возможно). |
| `optimizeAutoloader` | `bool` | Если `true`, то в команду `composer` будет добавлена опция `--optimize-autoloader` (оптимизация автозагрузчика `composer`). |
| `noInteraction` | `bool` | Если `true`, то в команду `composer` будет добавлена опция `--no-interaction` (игнорирование интерактивных вызовов во время выполнения задачи). |
| `verbose` | `bool|int` | Если `true` или число от 1 до 3, то в команду `composer` будет добавлена опция `--verbose`, `-v`, `-vv`, `-vvv` (более подробный output). |
| `quiet` | `bool` | Если `true`, то в команду `composer` будет добавлена опция `--quiet` (тихий режим). |

Примеры конфигурации
--------------------
```php
[
    // ./build composer
    // ./build composer/require
    // ./build composer/install-dry
    // ./build composer/install-prod
    // ./build composer/install
    // ./build composer/update-dry
    // ./build composer/update-prod
    // ./build composer/update
    // ./build composer/selfupdate
    // ./build composer/rollback
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

#Задача устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`. Если файла нет, все зависимости будут установлены через команду `composer/update`.
./build composer/install

#Задача покажет какие пакеты будут установлены, но при этом ничего не установит.
./build composer/install-dry

#Эта задача как и предыдущая - устанавливает все пакеты с зафиксированными версиями из файла `composer.lock`, но при этом игнорирует блок `require-dev` (для продакшена). Если файла нет, все зависимости будут установлены через компанду `composer/update-prod`.
./build composer/install-prod

#Задача обновляет все зависимые пакеты из файла `composer.json` до актуальных версий.
./build composer/update

#Задача покажет какие пакеты будут обновлены, но при этом ничего не обновит.
./build composer/update-dry

#Эта задача как и предыдущая - обновляет все зависимые пакеты из файла `composer.json` до актуальных версий, но при этом игнорирует блок `require-dev` (для продакшена).
./build composer/update-prod

#Задача обновляет скрипт `composer.phar` до последней версии.
./build composer/self-update

#Задача обновляет скрипт `composer.phar` до последней версии (алиас для команды `composer/self-update`).
./build composer/selfupdate

#Задача откатывает скрипт `composer.phar` до предыдущей версии.
./build composer/rollback

#Задача откатывает скрипт `composer.phar` до предыдущей версии (алиас для команды `composer/rollback`).
./build composer/revert
```

[**\cookyii\build\tasks\ComposerTask**]: https://github.com/cookyii/build/blob/master/tasks/ComposerTask.php
[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`MapTask`]: 03-reference-task-map.md