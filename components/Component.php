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
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }
}