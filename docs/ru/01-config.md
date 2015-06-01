Конфигурация билда
==================

* [Концепция](#Концепция)
* [Задача в её физическом представлении](#Задача-в-её-физическом-представлении)
* [`build.php` (Default type)](#build-php-default-type)
* [`build.json` (Json type)](#build-json-json-type)
* [`build.xml` (XML type)](#build-xml-xml-type)

Концепция
---------

Конфигурация билда представляет собой коллекцию из задач, которые можно\нужно выполнить для сборки проекта.
Конфигурация может быть задана несколькими способами: по умолчанию (php файл), в формате json либо xml.
Каждая задача в коллекции может иметь дочерние задачи или зависимые задачи.

**Общие моменты конфигурации задачи**

Каждая задача представляет собой массив определённых данных:
* `.description` - описание задачи. Просто полезная мелочь.
* `.task` - название класса или массив конфигурации задачи. В случае если не нужно указывать дополнительных параметров для конфигурации задачи, значение может быть просто строкой. Если требуется указать дополнительные параметры (например путь к какому-то файлу), то необходимо использовать массив.
* `.depends` - массив со списком названий задач, которые необходимо выполнить перед текущей задачей. Чуть ниже мы коснемся этой темы более подробно.

все остальные данные в конфигурации задачи считаются дочерними задачами. Об этом чуть ниже.

Например:
```php
<?php
return [
    // ./build less
    'less' => [
        // в этом случае не нужно указывать доп параметров
        // класс LessCompileTask сам знает где ему брать less файлы
        '.task' => 'app\build\tasks\LessCompileTask',
    ],
    
    // ./build composer
    'composer' => [
        // в этом случае нужно указать доп параметр composer
        // т.к. этот универсальный класс не знает где лежит исполняемый файл
        '.task. => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'composer' => '../composer.phar',
        ],
    ],
    
    // ./build some-task
    'some-task' => [
        // описание задачи
        '.description' => 'Эта задача что-то делает',
    
        // название класса задачи
        '.task' => 'app\build\tasks\SomeTask',
        
        // зависимые задачи
        '.depends' => ['check-available'],
    ],
    
    // ./build check-available
    'check-available' => [
        // описание задачи
        '.description' => 'Эта задача что-то проверяет на доступность',
        
        // название класса задачи
        '.task' => 'app\build\tasks\CheckAvailableTask',
        
        // дочерняя задача
        // ./build check-available/socket
        'socket' => [
            // описание задачи
            '.description' => 'Эта задача проверяет сокет на доступность',
            
            // название класса задачи
            '.task' => 'app\build\tasks\CheckAvailableWebSocketTask',
        ],
    ],
];
```

**Зависимости**

Каждая задача может иметь зависимые задачи. То есть задачи, которые должны быть выполнены перед текущей задачей.
В системе реализована простейшая система определния зацикливания задач. Если одна и таже задача вызывается более 
[`--loop-threshold`][] раз, происходит ошибка зацикливания.

Зависимости указыватся в конфигурации под специальным ключём `.depends`.

Например:
```php
<?php
return [
    'less' => [
        '.depends' => ['check-css-dir'],
        // compile less
    ],
    
    'check-css-dir' => [
        // check css dir exists
    ],
];
```

**Дочерние задачи**

Группа задач со схожим смыслом могут быть объеденены в группу. Например:

Неупорядоченные задачи по компиляции `less` стилей:
```php
<?php
return [
    // ./build less
    'less' => [
        // compile less for frontend
    ],
    
    // ./build less/backend
    'less/backend' => [
        // compile less for backend
    ], 
];
```

Сгруппированый вариант:
```php
<?php
return [
    'less' => [
        // ./build less/frontend
        'frontend' => [
            // compile less for frontend
        ],

        // ./build less/backend
        'backend' => [
            // compile less for backend
        ],
    ]
];
```

Эти обе конфигурации будут работать. Это просто удобный способ объединения задач, в случае их большого количества.

Задача в её физическом представлении
------------------------------------
Внутри, задача представляет собой особым образом сконфигурированный объект. 
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
* [`ReplacementTask`][] - задача заменяет определённые подстроки в файле.

[наверх](#Использование)

`build.php` (Default type)
----------------------

Конфигурационный файл `build.php` представляет собой обычный PHP файл, который возвращает массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи.

Пример:

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

`build.json` (Json type)
--------------------

Конфигурационный файл `build.json` представляет собой обычный JSON файл, который содержит массив с описанием инструкций для сборки.
Ключи массива - название задачи (таска), значения - конфигурация задачи.

Пример:

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

`build.xml` (XML type)
------------------
WIP

[наверх](#Использование)

[`--loop-threshold`]: 02-usage.md
[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`AbstractTask`]: 03-reference-abstract-task.md
[`BlankTask`]: 03-reference-task-blank.md
[`CallableTask`]: 03-reference-task-callable.md
[`CommandTask`]: 03-reference-task-command.md
[`ComposerTask`]: 03-reference-task-composer.md
[`DeleteTask`]: 03-reference-task-delete.md
[`EchoTask`]: 03-reference-task-echo.md
[`FileExistsTask`]: 03-reference-task-file-exists.md
[`LockTask`]: 03-reference-task-lock.md
[`MapTask`]: 03-reference-task-map.md
[`ReplacementTask`]: 03-reference-task-replacement.md