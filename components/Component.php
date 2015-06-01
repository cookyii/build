<?php
/**
 * Component.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\components;

/**
 * Class Component
 * @package cookyii\build\components
 */
class Component
{

    /** @var \Symfony\Component\EventDispatcher\EventDispatcher */
    public static $eventDispatcher;

    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (is_array($config) && !empty($config)) {
            $this->configure($config);
        }

        $this->init();
    }

    /**
     * Initial
     */
    public function init()
    {
    }

    /**
     * @param array $attributes
     * @return self
     */
    public function configure($attributes)
    {
        if (is_array($attributes) && !empty($attributes)) {
            foreach ($attributes as $attr => $value) {
                $this->$attr = $value;
            }
        }

        return $this;
    }

    /**
     * @copyright Copyright (c) 2008 Yii Software LLC
     *
     * Creates a new object using the given configuration.
     *
     * You may view this method as an enhanced version of the `new` operator.
     * The method supports creating an object based on a class name, a configuration array or
     * an anonymous function.
     *
     * Below are some usage examples:
     *
     * ```php
     * // create an object using a class name
     * $object = Component::createObject('app\model\Example');
     *
     * // create an object using a configuration array
     * $object = Component::createObject([
     *     'class' => 'app\model\Example',
     *     'context' => $this,
     * ]);
     *
     * // create an object with two constructor parameters
     * $object = Component::createObject('app\model\Example', [$this, rand()]);
     * ```
     *
     * @param string|array|callable $type the object type. This can be specified in one of the following forms:
     *
     * - a string: representing the class name of the object to be created
     * - a configuration array: the array must contain a `class` element which is treated as the object class,
     *   and the rest of the name-value pairs will be used to initialize the corresponding object properties
     * - a PHP callable: either an anonymous function or an array representing a class method (`[$class or $object, $method]`).
     *   The callable should return a new instance of the object being created.
     *
     * @param array $params the constructor parameters
     * @return object
     * @throws \Exception if the configuration is invalid.
     */
    public static function createObject($type, array $params = [])
    {
        if (is_string($type)) {
            return new $type($params);
        } elseif (is_array($type) && isset($type['class'])) {
            $class = $type['class'];
            unset($type['class']);
            return new $class($type);
        } elseif (is_callable($type, true)) {
            return call_user_func($type, $params);
        } elseif (is_array($type)) {
            throw new \Exception('Object configuration must be an array containing a "class" element.');
        } else {
            throw new \Exception(sprintf('Unsupported configuration type: %s', gettype($type)));
        }
    }

    /**
     * @param array $events
     *
     * only listeners
     * [
     *  'listeners' => [
     *      'onSomeEvent' => ['app\helper\Test', 'someMethod'],
     *      'onOtherEvent' => [
     *          ['app\helper\Test', 'someMethod'],
     *          'someFunction',
     *          function() {
     *              // ...
     *          }
     *      ],
     *  ],
     * ]
     *
     * only subscribers
     * [
     *  'subscribers' => [
     *      'onSomeEvent' => 'app\subscribers\SomeSubscriber',
     *      'onOtherEvent' => [
     *          'app\subscribers\SomeSubscriber',
     *          new app\subscribers\OtherSubscriber(),
     *      ],
     *  ],
     * ]
     *
     * all
     * [
     *  'listeners' => [
     *      'onSomeEvent' => [],
     *      'onOtherEvent' => [],
     *  ],
     *  'subscribers' => [
     *      'onSomeEvent' => [],
     *      'onOtherEvent' => [],
     *  ],
     * ]
     * @return array
     */
    public static function decomposeEventListenersConfig(array $events = [])
    {
        $subscribers = [];
        $listeners = [];

        if (!empty($events)) {
            if (!isset($events['subscribers']) && !isset($events['listeners'])) {
                $subscribers = [];
                $listeners = $events;
            } elseif (isset($events['subscribers'])) {
                $subscribers = $events['subscribers'];
                $listeners = [];
            } elseif (isset($events['listeners'])) {
                $subscribers = [];
                $listeners = $events['listeners'];
            } else {
                $subscribers = $events['subscribers'];
                $listeners = $events['listeners'];
            }
        }

        return [$subscribers, $listeners];
    }

    public static function addEventListeners(array $events = [])
    {
        if (!empty($events)) {
            list($subscribers, $listeners) = self::decomposeEventListenersConfig($events);

            if (!empty($subscribers)) {
                foreach ($subscribers as $subscriberClass) {
                    if (is_array($subscriberClass)) {
                        foreach ($subscriberClass as $className) {
                            static::getEventDispatcher()
                                ->addSubscriber(new $className);
                        }
                    } elseif (is_object($subscriberClass)) {
                        static::getEventDispatcher()
                            ->addSubscriber($subscriberClass);
                    } else {
                        static::getEventDispatcher()
                            ->addSubscriber(new $subscriberClass);
                    }
                }
            }

            if (!empty($listeners)) {
                foreach ($listeners as $eventName => $listener) {
                    if (is_array($listener) && !is_callable($listener)) {
                        foreach ($listener as $handler) {
                            static::getEventDispatcher()
                                ->addListener($eventName, $handler);
                        }
                    } else {
                        static::getEventDispatcher()
                            ->addListener($eventName, $listener);
                    }
                }
            }
        }
    }

    public static function removeEventListeners(array $events = [])
    {
        if (!empty($events)) {
            list($subscribers, $listeners) = self::decomposeEventListenersConfig($events);

            if (!empty($subscribers)) {
                foreach ($subscribers as $subscriberClass) {
                    if (is_array($subscriberClass)) {
                        foreach ($subscriberClass as $className) {
                            static::getEventDispatcher()
                                ->removeSubscriber(new $className);
                        }
                    } elseif (is_object($subscriberClass)) {
                        static::getEventDispatcher()
                            ->removeSubscriber($subscriberClass);
                    } else {
                        static::getEventDispatcher()
                            ->removeSubscriber(new $subscriberClass);
                    }
                }
            }

            if (!empty($listeners)) {
                foreach ($listeners as $eventName => $listener) {
                    if (is_array($listener) && !is_callable($listener)) {
                        foreach ($listener as $handler) {
                            static::getEventDispatcher()
                                ->removeListener($eventName, $handler);
                        }
                    } else {
                        static::getEventDispatcher()
                            ->removeListener($eventName, $listener);
                    }
                }
            }
        }
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name)
    {
        return $this->canGetProperty($name) || $this->canSetProperty($name);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function canGetProperty($name)
    {
        return property_exists($this, $name);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function canSetProperty($name)
    {
        return property_exists($this, $name);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public static function getEventDispatcher()
    {
        if (empty(static::$eventDispatcher)) {
            static::$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        }

        return static::$eventDispatcher;
    }
}