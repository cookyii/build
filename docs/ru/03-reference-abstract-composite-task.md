AbstractCompositeTask
=====================

[**\cookyii\build\tasks\AbstractCompositeTask**](https://github.com/cookyii/build/blob/master/tasks/AbstractCompositeTask.php)

Этот абстрактный класс позваляет создавать так назваемую композитную задачу.
То есть задача, которая содержит в себе сразу несколько задач.

Это может пригодиться, например, для реализации различных вариаций одной и той же команды.
Например [`ComposerTask`][]. Эта команда предоставляет отдельные задачи для установки и обновления пакетов.

Для создания композитной задачи необходимо создать новый класс, унаследовать его от `cookyii\build\tasks\AbstractCompositeTask`
и реализовать в нём метод `tasks`. Этот метод должен возвращать (конфигурацию)[01-usage.md] нужных задач.

Напимер:
```php
class MyCompositeTask extends \cookyii\build\tasks\AbstractCompositeTask
{

    /**
     * @return array
     */
    public function tasks()
    {
        return [
            'default' => [
                'depends' => ['execute-something'],
                'description' => 'Default task for `MyCompositeTask`',
            ],

            'show-something' => [
                '.description' => 'Show something',
                '.task' => [
                    'class' => '\cookyii\build\tasks\EchoTask',
                    'message' => 'Hello world!',
                ],
            ],
            'execute-something' => [
                '.description' => 'Execute something',
                '.task' => [
                    'class' => '\cookyii\build\tasks\CommandTask',
                    'commandline' => 'ls -lah',
                ],
            ],
        ];
    }
}
```

Reference
---------

Класс `AbstractCompositeTask` наследует все атрибуты и методы класса [`AbstractTask`][], а также имеет ряд собственных атрибутов.

| Атрибут | Тип | Описание | 
| ------- | --- | -------- |
| `defaultTask` | `string` | Название задачи, которая будет выполнена по умолчанию. |

[`AbstractTask`]: 03-reference-abstract-task.md
[`ComposerTask`]: 03-reference-task-composer.md
