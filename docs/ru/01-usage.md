Использование
=============

* [Команда `build`](#Команда-build)
* [Команда `build`](#Команда-build)

Команда `build`
---------------

Для сборки проекта необходимо использовать команду `build`. По умолчанию она устанавливается в директорию `vendor/bin/build`.

Reference команды `build`
```sh
build [-c|--config[="..."]] [-t|--config-type[="..."]] [-d|--task-delimiter[="..."]] [-l|--loop-threshold[="..."]] [task]
```

| Параметр | По умолчанию | 
| -------- | ------------ |
| `-c|--config` - путь к файлу конфигурации сборки проекта. | `build.php` |
| `-t|--config-type` - тип конфигурационного файла. Конфиграция может быть написана в разных форматах. Варианты: `default`, `json`, `phing`. Например, в будущем, можно будет использовать xml конфиг от phing. | `default` |
| `-d|--task-delimiter` - Разделитель иерархии задач. Названия задач можно задавать через разделительно. Например: `build/production`, `less/compile` | `/` |
| `-l|--loop-threshold` - Количество повторений одной задачи, которые считается за ошибку зацикливания. Если одна заадча будет повторена три раза (по умолчанию), то будет выброшено исключение `RuntimeException`. | `3` |
| `task` - Задача, которую нужно выполнить. | `default` |

*** Примеры использования ***
```sh
./vendor/bin/build -c my-build.php default 
# заупстить таск default из конфиг файла my-build.php

./vendor/bin/build migrate/backend 
# заупстить таск migrate/backend из конфиг файла build.php
```

### Концепция задач
Конфигурация билда состоит из задач. Задача представляет собой особым образом сконфигурированный объект. 
В данный момент в `cookyii/build` доступны следующие задачи:
* `[CallableTask][]` - задача выполняется произвольную php функцию (callable).
* `[CommandTask][]` - задача выполняет произвольную программу в командной строке (cli command).
* `[DeleteTask][]` - задача удаляет файлы.
* `[EchoTask][]` - задача выводит произвольное сообщение.
* `[FileExistsTask][]` - задача проверяет существование файла.
* `[MapTask][]` - задача выводит карту всех доступных задач.

Задачи могут быть собраны в иерархию.
Также задачи могут быть зависимы (depend) от других задач.

Reference конфигурации задачи

| Атрибут | Описание | 
| ------- | -------- |
| `class` | Название PHP класса задачи |
| `description` | Описание задачи (для задачи `[MapTask][]`, но будет полезно просто видеть описание в конфигурационном файле) |
| `depends` | Массив задач, которые должны быть выполнены перед текущей задачей |
| `*` | Остальные атрибуты, которые требуются для конкретной задачи |

### Конфигурационный файл `build.php` (config-type `default`)
Конфигурационный файл `build.php` представляет собой обычный PHP файл, который возвращает массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи. 

Например:
```php
<?php

return [
    // ./build default
    'default' => [
        'class' => cookyii\build\tasks\EchoTask::className(),
        'description' => 'Run default task',
        'message' => 'Executing default task...',
    ],

    'build' => [
        // ./build build/prod
        'prod' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Run production build',
            'message' => 'Executing production build...',
        ],

        // ./build build/dev
        'dev' => [
            'class' => cookyii\build\tasks\EchoTask::className(),
            'description' => 'Run dev build',
            'message' => 'Executing dev build...',
        ],
    ],
];
```

### Конфигурационный файл `build.json` (config-type `json`)
Конфигурационный файл `build.json` представляет собой обычный JSON файл, который содержит массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи. 

```json
{
  "default": {
    "class": "cookyii\\build\\tasks\\EchoTask",
    "description": "Run default task",
    "message": "Executing default task..."
  },

  "build": {
    "prod": {
      "class": "cookyii\\build\\tasks\\EchoTask",
      "description": "Run production build",
      "message": "Executing production build..."
    },
    "dev": {
      "class": "cookyii\\build\\tasks\\EchoTask",
      "description": "Run dev build",
      "message": "Executing dev build..."
    }
  }
}
```

### Конфигурационный файл `build.xml` (config-type `phing`)
WIP

[CallableTask]: docs/ru/02-reference-task-callable.md
[CommandTask]: docs/ru/02-reference-task-command.md
[DeleteTask]: docs/ru/02-reference-task-delete.md
[EchoTask]: docs/ru/02-reference-task-echo.md
[FileExistsTask]: docs/ru/02-reference-task-file-exists.md
[MapTask]: docs/ru/02-reference-task-map.md
