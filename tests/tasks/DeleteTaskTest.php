<?php
/**
 * DeleteTaskTest.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tests\tasks;

/**
 * Class DeleteTaskTest
 * @package cookyii\build\tests\tasks
 */
class DeleteTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        $config = $this->getConfig();
        $directory = $config['delete']['.task']['fileSets'][0]['dir'];

        $this->assertFalse(file_exists($directory));

        mkdir($directory);
        touch($directory . '/test.a.log');
        touch($directory . '/test.b.php');

        $this->assertTrue(file_exists($directory));

        list($return, $output) = $this->executeTask('delete', ['v' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('DEL', $output);
        $this->assertContains($directory, $output);
        $this->assertContains('Build finished', $output);

        $this->assertFalse(file_exists($directory));
    }
}