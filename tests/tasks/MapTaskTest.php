<?php
/**
 * MapTaskTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class MapTaskTest
 * @package cookyii\build\tests\tasks
 */
class MapTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        list($return, $output) = $this->executeTask('map');

        $this->assertTrue($return === 0);
        $this->assertContains('Execute MapTask', $output);
        $this->assertContains('Build finished', $output);
    }
}