<?php
/**
 * EchoTaskTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class EchoTaskTest
 * @package cookyii\build\tests\tasks
 */
class EchoTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('echo');

        $this->assertTrue($return === 0);
        $this->assertContains('Echo task executed', $output);
        $this->assertContains('Build finished', $output);
    }
}