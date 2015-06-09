<?php
/**
 * CallableTaskTest.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tests\tasks;

/**
 * Class CallableTaskTest
 * @package cookyii\build\tests\tasks
 */
class CallableTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('callable');

        $this->assertTrue($return === 0);
        $this->assertContains('Callable task executed', $output);
        $this->assertContains('Build finished', $output);
    }

    public function testFailure()
    {
        list($return, $output) = $this->executeTask('callable/failure');

        $this->assertTrue($return === 1);
        $this->assertContains('Oh no...', $output);
        $this->assertContains('failure', $output);
        $this->assertContains('Build finished', $output);
    }
}