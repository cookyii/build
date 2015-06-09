<?php
/**
 * ComposerTaskTest.php
 * @author Revin Roman
 * @link https://github.com/cookyii/build
 */

namespace cookyii\build\tests\tasks;

/**
 * Class ComposerTaskTest
 * @package cookyii\build\tests\tasks
 */
class ComposerTaskTest extends \cookyii\build\tests\BaseTestCase
{

    public function tearDown()
    {
        (new \Symfony\Component\Filesystem\Filesystem())
            ->remove($this->getRuntimePath() . '/vendor');

        parent::tearDown();
    }

    public function testMain()
    {
        list($return, $output) = $this->executeTask('composer');

        $this->assertTrue($return === 0);
        $this->assertContains('composer[default]', $output);
        $this->assertContains('Show map subtasks', $output);
        $this->assertContains('Build finished', $output);
    }

    public function testRequire()
    {
        list($return, $output) = $this->executeTask('composer/require psr/log:^1.0', ['v' => true]);

        $this->assertContains('require psr/log', $output);
        $this->assertContains('Build finished', $output);

        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/log'));
    }

    public function testUpdate()
    {
        list($return, $output) = $this->executeTask('composer/update', ['v' => true]);

        $this->assertContains('update', $output);
        $this->assertContains('--no-dev', $output);
        $this->assertContains('Build finished', $output);

        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/log'));
        $this->assertFalse(file_exists($this->getRuntimePath() . '/vendor/psr/http-message'));
    }

    public function testInstall()
    {
        list($return, $output) = $this->executeTask('composer/install', ['v' => true]);

        $this->assertContains('install', $output);
        $this->assertContains('--no-dev', $output);
        $this->assertContains('Build finished', $output);

        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/log'));
        $this->assertFalse(file_exists($this->getRuntimePath() . '/vendor/psr/http-message'));
    }

    public function testUpdateDev()
    {
        list($return, $output) = $this->executeTask('composer/update-dev', ['v' => true]);

        $this->assertContains('update', $output);
        $this->assertContains('Build finished', $output);

        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/log'));
        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/http-message'));
    }

    public function testInstallDev()
    {
        list($return, $output) = $this->executeTask('composer/install-dev', ['v' => true]);

        $this->assertContains('install', $output);
        $this->assertContains('Build finished', $output);

        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/log'));
        $this->assertTrue(file_exists($this->getRuntimePath() . '/vendor/psr/http-message'));
    }
}