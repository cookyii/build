<?php
/**
 * BaseTestCase.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests;

/**
 * Class BaseTestCase
 * @package cookyii\build\tests
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @return string
     */
    public function getRuntimePath()
    {
        return __DIR__ . '/runtime';
    }

    /**
     * @param array $options
     * @return array
     */
    public function getConfig(array $options = [])
    {
        if (!isset($options['c']) && !isset($options['config'])) {
            $options['c'] = realpath(__DIR__ . '/config/base.php');
        }

        return include($options['c']);
    }

    /**
     * @param string $task_name
     * @param array $options
     * @return array
     */
    protected function executeTask($task_name, array $options = [])
    {
        if (!isset($options['c']) && !isset($options['config'])) {
            $options['c'] = realpath(__DIR__ . '/config/base.php');
        }

        $o = [];
        foreach ($options as $k => $v) {
            if (is_bool($v) && (bool)$v === true) {
                $o[] = '-' . $k;
            } elseif (mb_strlen($k, 'utf-8') === 1) {
                $o[] = '-' . $k . escapeshellarg($v);
            } else {
                $o[] = '--' . $k . '=' . escapeshellarg($v);
            }
        }

        $cmd = implode(' ', [
            realpath(__DIR__ . '/../build'),
            implode(' ', $o),
            $task_name
        ]);

        if (in_array('--debug', $_SERVER['argv'], true)) {
            echo sprintf("\nexecuting %s\n", $cmd);
        }

        ob_start();
        passthru($cmd, $return);
        $output = ob_get_clean();

        return [$return, $output];
    }
}