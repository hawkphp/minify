<?php

namespace Hawk\Tests\Psr7;

use Hawk\Minify\BuilderFileMap;
use PHPUnit\Framework\TestCase;

/**
 * Class BuilderFileMapTest
 * @package Hawk\Tests\Psr7
 */
class BuilderFileMapTest extends TestCase
{
    public function getBuilderFactory()
    {
        return new BuilderFileMap();
    }

    public function testScanPathAndCompareFiles()
    {
        $filePath = realpath(__DIR__) . '/assets/src';
        $builder = $this->getBuilderFactory();
        $builder->scan($filePath);

        $files = array(
            '/home/ru/www/predeploy/tests/assets/src/MinifyStarter.php',
            '/home/ru/www/predeploy/tests/assets/src/css/common.css',
            '/home/ru/www/predeploy/tests/assets/src/js/common.js',
        );

        $this->assertEquals($files, $builder->getFiles());
    }
}
