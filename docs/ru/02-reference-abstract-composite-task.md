AbstractCompositeTask
=====================

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
                'description' => 'Install all depending for development environment (with `require-dev`)',
            ],

            'show-something' => [
                'class' => '\cookyii\build\tasks\EchoTask',
                'description' => 'Show something',
                'message' => 'Hello world!',
            ],
            'execute-something' => [
                'class' => '\cookyii\build\tasks\CommandTask',
                'description' => 'Execute something',
                'commandline' => 'ls -lah',
            ],
        ];
    }
}
```

[`ComposerTask`]: 02-reference-task-composer.md