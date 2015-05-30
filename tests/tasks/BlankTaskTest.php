<?php
/**
 * BlankTaskTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class BlankTaskTest
 * @package cookyii\build\tests\tasks
 */
class BlankTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('blank', ['vv' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Blank task executed', $output);
        $this->assertContains('Build finished', $output);
    }
}