AbstractTask
============

Этот абстрактный класс позваляет создавать задачу для выполнения в `cookyii/build`.

Для создания задачи необходимо создать новый класс, унаследовать его от `cookyii\build\tasks\AbstractTask`
и реализовать в нём метод `run`. Этот метод должен возвращать boolean (true в случае успеха, false в случае неудачи).

Напимер:
```php
class MyTask extends \cookyii\build\tasks\AbstractTask
{

    /** @var string|null */
    public $message;

    /**
     * @return bool
     */
    public function run()
    {
        if (empty($this->message)) {
            throw new \InvalidArgumentException('Empty message.');
        } else {
            $this->log((string)$message);

            return true;
        }
    }
}
```