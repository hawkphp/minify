<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\MapFileBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class FileMapBuilderTest
 * @package Hawk\Tests\Minify
 */
class FileMapBuilderTest extends TestCase
{
    /**
     * @return MapFileBuilder
     */
    public function getBuilderFactory()
    {
        return new MapFileBuilder();
    }

    public function testScanPathAndCompareFiles()
    {
        $filePath = realpath(__DIR__) . '/assets/src';
        $builder = $this->getBuilderFactory();
        $builder->scan($filePath);

        $files = array(
            $filePath . '/MinifyStarter.php',
            $filePath . '/css/common.css',
            $filePath . '/js/common.js',
        );

        $this->assertEquals($files, $builder->getFiles());
    }
}
