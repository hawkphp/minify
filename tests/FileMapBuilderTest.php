<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\FileMapBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class FileMapBuilderTest
 * @package Hawk\Tests\Psr7
 */
class FileMapBuilderTest extends TestCase
{
    /**
     * @return FileMapBuilder
     */
    public function getBuilderFactory()
    {
        return new FileMapBuilder();
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
