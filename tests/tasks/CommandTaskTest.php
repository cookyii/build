<?php
/**
 * CommandTaskTest.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tests\tasks;

/**
 * Class CommandTaskTest
 * @package cookyii\build\tests\tasks
 */
class CommandTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('command', ['vv' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('EXEC', $output);
        $this->assertContains('"ls"', $output);
        $this->assertContains('BaseTestCase.php', $output);
        $this->assertContains('Build finished', $output);
    }
}