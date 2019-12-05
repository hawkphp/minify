<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\File;
use PHPUnit\Framework\TestCase;

/**
 * Class FileTest
 * @package Hawk\Tests\Minify
 */
class FileTest extends TestCase
{
    /**
     * @var string|null
     */
    private $fileFrom;

    /**
     * @var string|null
     */
    private $fileTo;

    public function setUp()
    {
        $testPath = realpath(__DIR__);
        $this->fileFrom = $testPath . "/assets/src/js/common.js";
        $this->fileTo = $testPath . "/assets/deploy/js/common.js";

        if (file_exists($this->fileTo)) {
            unlink($this->fileTo);
        }
    }

    public function testFileNotExists()
    {
        $this->assertFileNotExists($this->fileTo);
    }

    public function testCopyFile()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $file->copy();

        $this->assertFileExists($this->fileTo);
    }

    public function testFileCssNotExists()
    {
        $this->fileTo = realpath(__DIR__) . "/assets/deploy/css/common.css";

        if (file_exists($this->fileTo)) {
            unlink($this->fileTo);
        }

        $this->assertFileNotExists($this->fileTo);
    }

    public function testWrite()
    {
        $this->fileTo = realpath(__DIR__) . "/assets/deploy/css/common.css";

        $file = new File($this->fileFrom, $this->fileTo);
        $file->setResource(".Foo{Bar:Baz}")->write();

        $this->assertFileExists($this->fileTo);

        if (file_exists($this->fileTo)) {
            unlink($this->fileTo);
        }

        $this->assertFileNotExists($this->fileTo);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWriteFileFromIsNotExists()
    {
        $file = new File('Foo', 'Bar');
        $file->write();
    }

    public function testGetFileName()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $this->assertEquals('common.js', $file->getFileName());
    }

    public function testGetFilePath()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $this->assertEquals(pathinfo($this->fileFrom, PATHINFO_DIRNAME), $file->getPath());
    }

    public function testGetFileExtension()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $this->assertEquals('js', $file->getExt());
    }

    public function testIsNullResource()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $this->assertNull($file->getResource());
    }

    public function testSetResource()
    {
        $file = new File($this->fileFrom, $this->fileTo);
        $file->setResource('Foo');
        $this->assertEquals('Foo', $file->getResource());
    }

}