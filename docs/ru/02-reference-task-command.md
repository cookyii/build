CommandTask
===========

**\cookyii\build\tasks\CommandTask**

задача выполняет произвольную программу в командной строке (cli command).

Reference
---------

Класс `CommandTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `commandline` | `string|array` | Одна команда или массик команд, которые необходимо выполнить в cli. |
| `cwd` | `string|null` | Путь директории, в которой необходимо выполнить команду. |
| `callback` | `callable` | Анонимная функция или имя функции, заданное строковой переменной или массивом (например: `functionname`, `[$SomeObject, 'MethodName']`, `function(CommandTask $Task, $result){}`), которую необходимо выполнить после отработки программы. |

[`AbstractTask`]: 02-reference-abstract-task.md