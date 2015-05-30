Использование
=============

* [Команда `build`](#Команда-build)
* [Концепция задач](#Концепция-задач)
* [Конфигурационный файл `build.php` (config-type `default`)](#Конфигурационный-файл-buildphp-config-type-default)
* [Конфигурационный файл `build.json` (config-type `json`)](#Конфигурационный-файл-buildjson-config-type-json)
* [Конфигурационный файл `build.xml` (config-type `phing`)](#Конфигурационный-файл-buildxml-config-type-phing)

Команда `build`
---------------

Для сборки проекта необходимо использовать команду `build`. По умолчанию она устанавливается в директорию `vendor/bin/build`.

Reference команды `build`
```sh
build \
    [-c|--config[="..."]] \
    [-t|--config-type[="..."]] \
    [--task-delimiter[="..."]] \
    [--loop-threshold[="..."]] \
    [--disable-events[="..."]] \
    [--color[="..."]] \
    [task]
```

| Параметр | По умолчанию | 
| -------- | ------------ |
| `-c|--config` - путь к файлу конфигурации сборки проекта. | `build.php` |
| `-t|--config-type` - тип конфигурационного файла. Конфиграция может быть написана в разных форматах. Варианты: `default`, `json`. Например, в будущем, можно будет использовать xml конфиг от phing. | `default` |
| `--task-delimiter` - Разделитель иерархии задач. Названия задач можно задавать через разделительно. Например: `build/production`, `less/compile` | `/` |
| `--loop-threshold` - Количество повторений одной задачи, которые считается за ошибку зацикливания. Если одна заадча будет повторена три раза (по умолчанию), то будет выброшено исключение `RuntimeException`. | `3` |
| `--disable-events` - Если значение `yes`, `force`, `always` или `true`, то во время запуска будут проигнорированы все события. | `false` |
| `--color` - Если значение `no`, `none` или `never`, то вывод в консоли будет обесцвечен (не бдет применена цветовая индикация сообщений в output). | `yes` |
| `task` - Задача, которую нужно выполнить. | `default` |

**Примеры использования**
```sh
./vendor/bin/build -c my-build.php default 
# заупстить таск default из конфиг файла my-build.php

./vendor/bin/build migrate/backend 
# заупстить таск migrate/backend из конфиг файла build.php
```

[наверх](#Использование)

### Концепция задач
Конфигурация билда состоит из задач. 
Задача представляет собой особым образом сконфигурированный объект. 
Этот объект должен наследоваться от [`AbstractTask`][] или [`AbstractCompositeTask`][].
В данный момент в `cookyii/build` доступны следующие задачи:
* [`BlankTask`][] - задача-заглушка, которая используется когда не указан класс задачи.
* [`CallableTask`][] - задача выполняется произвольную php функцию (callable).
* [`CommandTask`][] - задача выполняет произвольную программу в командной строке (cli command).
* [`ComposerTask`][] - задача выполняет различные операции composer.
* [`DeleteTask`][] - задача удаляет файлы.
* [`EchoTask`][] - задача выводит произвольное сообщение.
* [`FileExistsTask`][] - задача проверяет существование файла.
* [`LockTask`][] - задача управляет блокировкой файла.
* [`MapTask`][] - задача выводит карту всех доступных задач.

Задачи могут быть собраны в иерархию.
Также задачи могут быть зависимы (depend) от других задач.

Reference конфигурации задачи

| Атрибут | Описание | 
| ------- | -------- |
| `.task` | Массив конфигурации или название PHP класса задачи |
| `.description` | Описание задачи (для задачи [`MapTask`][], но будет полезно просто видеть описание в конфигурационном файле) |
| `.depends` | Массив задач, которые должны быть выполнены перед текущей задачей |
| `*` | Остальные атрибуты, которые требуются для конкретной задачи |

[наверх](#Использование)

### Конфигурационный файл `build.php` (config-type `default`)
Конфигурационный файл `build.php` представляет собой обычный PHP файл, который возвращает массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи. 

Например:
```php
<?php

return [
    // ./build default
    'default' => [
        '.description' => 'Run default task',
        '.task' => [
            'class' => 'cookyii\build\tasks\EchoTask',
            'message' => 'Executing default task...',
        ],
    ],

    'build' => [
        // ./build build/prod
        'prod' => [
            '.description' => 'Run production build',
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Executing production build...',
            ],
        ],

        // ./build build/dev
        'dev' => [
            '.description' => 'Run dev build',
            '.task' => [
                'class' => 'cookyii\build\tasks\EchoTask',
                'message' => 'Executing dev build...',
            ],
        ],
    ],
];
```

[наверх](#Использование)

### Конфигурационный файл `build.json` (config-type `json`)
Конфигурационный файл `build.json` представляет собой обычный JSON файл, который содержит массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи. 

```json
{
  "default": {
    ".description": "Run default task",
    ".task": {
        "class": "cookyii\\build\\tasks\\EchoTask",
        "message": "Executing default task..."
    }
  },

  "build": {
    "prod": {
      ".description": "Run production build",
      ".taks": {
        "class": "cookyii\\build\\tasks\\EchoTask",
        "message": "Executing production build..."
      }
    },
    "dev": {
      ".description": "Run dev build",
      ".task": {
        "class": "cookyii\\build\\tasks\\EchoTask",
        "message": "Executing dev build..."
      }
    }
  }
}
```

[наверх](#Использование)

### Конфигурационный файл `build.xml` (config-type `phing`)
WIP

[наверх](#Использование)

[`AbstractCompositeTask`]: 02-reference-abstract-composite-task.md
[`AbstractTask`]: 02-reference-abstract-task.md
[`BlankTask`]: 02-reference-task-blank.md
[`CallableTask`]: 02-reference-task-callable.md
[`CommandTask`]: 02-reference-task-command.md
[`ComposerTask`]: 02-reference-task-composer.md
[`DeleteTask`]: 02-reference-task-delete.md
[`EchoTask`]: 02-reference-task-echo.md
[`FileExistsTask`]: 02-reference-task-file-exists.md
[`LockTask`]: 02-reference-task-lock.md
[`MapTask`]: 02-reference-task-map.md