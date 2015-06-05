Написание собственных задач (task)
==================================

Задача представляет собой особым образом сконфигурированный объект. 
Этот объект должен наследоваться от [`AbstractTask`][] или [`AbstractCompositeTask`][].

Создание обычной задачи `AbstractTask`
--------------------------------------

Для создания обычной задачи необходимо создать новый класс и унаследовать его от класса [`AbstractTask`][].
Далее достаточно реализовать метод `run` и задача готова к использованию!

Метод `run` не принимает никаких аргументов и должен возвращать `boolean` значение (`false` - в случае провала, `true` - в случае успеха).

В классе задачи доступны несколько свойств:
* `command` - ссылка на экземпляр класса [`BuildCommand`][]
* `input` - ссылка на экземпляр класса с интерфейсом [`InputInterface`][]
* `output` - ссылка на экземпляр класса с интерфейсом [`OutputInterface`][]

И несколаько методов:
* `log($message, $indent = 0, $newLine = true)` - отобразить строку текста `$message`, со смещением от левой границы терминала на `$indent` шагов.
* `getFileSystemHelper()` - метод возвращает экземпляр хелпера для работы с файловой системой.

Благодаря наличию ссылки на команду [`BuildCommand`][], задачи могут общаться между собой.
Для этого следует использовать `states`.

Пример класса:
```php
<?php

class MyLovelyTask extends \cookyii\build\tasks\AbstractTask
{

    public function run()
    {
        $result = false;
        
        // get global state var
        if(!$this->command->getState('othertask.state', false)) {
            throw new \Exception('Oh no...');
        }
    
        // your magic
        
        if($this->output->isVerbose()) {
            $this->log('All right man.');
        }
        
        // set global state var
        $this->command->setState('mylovelytask.state', $data);
        
        return $result;
    }
}
```

Создание композитной задачи `AbstractCompositeTask`
---------------------------------------------------

WIP

[`AbstractCompositeTask`]: 03-reference-abstract-composite-task.md
[`AbstractTask`]: 03-reference-abstract-task.md
[`BuildCommand`]: https://github.com/cookyii/build/blob/master/commands/BuildCommand.php
[`InputInterface`]: http://api.symfony.com/2.7/Symfony/Component/Console/Input/InputInterface.html
[`OutputInterface`]: http://api.symfony.com/2.7/Symfony/Component/Console/Output/OutputInterface.html