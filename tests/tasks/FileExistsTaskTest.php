<?php
/**
 * FileExistsTask.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\build\tests\tasks;

/**
 * Class FileExistsTask
 * @package cookyii\build\tests\tasks
 */
class FileExistsTask extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        $config = $this->getConfig();

        list($return, $output) = $this->executeTask('exists', ['v' => true]);

        $this->assertTrue($return === 1);
        $this->assertContains('not exists', $output);
        $this->assertContains('Build finished', $output);

        touch($config['exists']['.task']['filename']);

        list($return, $output) = $this->executeTask('exists', ['v' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Build finished', $output);

        unlink($config['exists']['.task']['filename']);
    }
}