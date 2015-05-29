CallableTask
============

**\cookyii\build\tasks\CallableTask**

Задача выполняется произвольную php функцию (callable).

Reference
---------

Класс `CallableTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `handler` | `callable` | Анонимная функция или имя функции, заданное строковой переменной или массивом (например: `functionname`, `[$SomeObject, 'MethodName']`, `function(CallableTask $Task){}`), которую необходимо выполнить в рамках текущей задачи. |

[`AbstractTask`]: 02-reference-abstract-task.md
