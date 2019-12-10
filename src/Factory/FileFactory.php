<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

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

        return  $file->read();
    }
}
