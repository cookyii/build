<?php
/**
 * LockTaskTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class LockTaskTest
 * @package cookyii\build\tests\tasks
 */
class LockTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('lock/lock', ['v' => true]);

//        var_dump($output);

        $this->assertTrue($return === 0);
        $this->assertContains('Build finished', $output);
    }
}