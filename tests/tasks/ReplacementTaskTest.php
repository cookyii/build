<?php
/**
 * ReplacementTaskTest.php
 * @author Revin Roman
 * @license The MIT License (MIT)
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tests\tasks;

/**
 * Class ReplacementTaskTest
 * @package cookyii\build\tests\tasks
 */
class ReplacementTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function testMain()
    {
        $config = $this->getConfig();

        $fp = fopen($config['replacement']['.task']['filename'], 'w+');
        fwrite($fp, '### Demo config' . "\n" . 'This is a secret key: #KEY#');

        list($return, $output) = $this->executeTask('replacement', ['vv' => true]);

        $this->assertTrue($return === 0);
        $this->assertContains('Placeholders replaced', $output);
        $this->assertContains('Build finished', $output);

        fseek($fp, 0);
        $content = fread($fp, 1024);

        $this->assertContains('This is a secret key', $content);
        $this->assertNotContains('#KEY#', $content);

        fclose($fp);
    }
}