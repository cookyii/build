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

        $this->assertTrue($return === 0);
        $this->assertContains('Locked [runtime]', $output);
        $this->assertContains('Build finished', $output);

        list($return, $output) = $this->executeTask('lock/check', ['v' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Locked [runtime]', $output);
        $this->assertContains('Build finished', $output);

        list($return, $output) = $this->executeTask('lock/release', ['v' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Released [runtime]', $output);
        $this->assertContains('Build finished', $output);

        list($return, $output) = $this->executeTask('lock/check', ['v' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Released [runtime]', $output);
        $this->assertContains('Build finished', $output);
    }
}