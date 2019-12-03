<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\Config;
use Hawk\Minify\Runner;
use PHPUnit\Framework\TestCase;

/**
 * Class RunnerTest
 * @package Hawk\Tests\Minify
 */
class RunnerTest extends TestCase
{
    /**
     * @var string
     */
    private $configFile;

    protected function setUp()
    {
        $this->configFile = realpath(__DIR__) . "/assets/config/minify.xml";
    }

    /**
     * @return Runner
     */
    public function getRunnerFactory()
    {
        $config = new Config($this->configFile);
        return new Runner($config);
    }

    public function testConfigFileExists()
    {
        $this->assertFileExists($this->configFile);
    }

    public function testGetNewFilePath()
    {
        $runner = $this->getRunnerFactory();
        $runnerNewFilePath = new \ReflectionMethod($runner, 'getFilePathTo');
        $runnerNewFilePath->setAccessible(true);

        $filePath = realpath(__DIR__) . '/assets/src/MinifyStarter.php';
        $assetsPath = realpath(__DIR__) . "/assets/";
        $newFilePath = $runnerNewFilePath->invokeArgs($runner, array($filePath, $assetsPath));

        $this->assertEquals(realpath(__DIR__) . '/assets/deploy/MinifyStarter.php', $newFilePath);
    }

    public function testIsFileExtAllowTrue()
    {
        $runner = $this->getRunnerFactory();
        $runnerIsFileExtAllow = new \ReflectionMethod($runner, 'isAllowFileExt');
        $runnerIsFileExtAllow->setAccessible(true);

        $dir = realpath(__DIR__);

        $filePath = $dir . '/assets/src/Foo.php';
        $this->assertTrue($runnerIsFileExtAllow->invokeArgs($runner, array($filePath)));

        $filePath = $dir . '/assets/src/Bar.css';
        $this->assertTrue($runnerIsFileExtAllow->invokeArgs($runner, array($filePath)));

        $filePath = $dir . '/assets/src/Baz.js';
        $this->assertTrue($runnerIsFileExtAllow->invokeArgs($runner, array($filePath)));

    }

    public function testIsFileExtAllowFalse()
    {
        $runner = $this->getRunnerFactory();
        $runnerIsFileExtAllow = new \ReflectionMethod($runner, 'isAllowFileExt');
        $runnerIsFileExtAllow->setAccessible(true);

        $filePath = realpath(__DIR__) . '/assets/src/Xyz.xss';
        $this->assertFalse($runnerIsFileExtAllow->invokeArgs($runner, array($filePath)));
    }

}