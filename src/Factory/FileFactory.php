<?php

namespace Hawk\Minify\Factory;

use Hawk\Minify\File;

/**
 * Class FileFactory
 * @package Hawk\Minify\Factory
 */
class FileFactory
{
    /**
     * @param $filePathFrom
     * @param $filePathTo
     * @return File
     */
    public function createFile($filePathFrom, $filePathTo)
    {
        $file = new File($filePathFrom, $filePathTo);
        $file->read();

        return $file;
    }
}
