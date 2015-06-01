<?php
/**
 * ComposerTaskTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class ComposerTaskTest
 * @package cookyii\build\tests\tasks
 */
class ComposerTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('composer');

        $this->assertTrue($return === 0);
        $this->assertContains('composer[default]', $output);
        $this->assertContains('Show map subtasks', $output);
        $this->assertContains('Build finished', $output);
    }

    public function testInstall(){

    }
}