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
            $filePath . '/MinifyStarter.php',
            $filePath . '/css/common.css',
            $filePath . '/js/common.js',
        );

        $this->assertEquals($files, $builder->getFiles());
    }
}
