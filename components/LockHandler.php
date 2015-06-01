<?php
/**
 * LockHandler.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\components;

/**
 * Class LockHandler
 * @package cookyii\build\components
 */
class LockHandler extends \Symfony\Component\Filesystem\LockHandler
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $file;

    /**
     * @inheritdoc
     */
    public function __construct($name, $lockPath = null)
    {
        parent::__construct($name, $lockPath);

        $lockPath = $lockPath ?: sys_get_temp_dir();

        $this->name = $name;
        $this->file = sprintf('%s/sf.%s.%s.lock', $lockPath, preg_replace('/[^a-z0-9\._-]+/i', '-', $name), hash('sha256', $name));
    }

    /**
     * @return string
     */
    public function getLockName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLockFileName()
    {
        return $this->file;
    }

//    public function
}