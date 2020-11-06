<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify;

use Hawk\Minify\Exceptions\TerminateException;

/**
 * Class FileMapBuilder
 * @package Hawk\Minify
 */
class MapFileBuilder
{
    /**
     * @var array
     */
    private $files = array();

    /**
     * @param $rootPath
     * @throws TerminateException
     */
    public function scan($rootPath)
    {
        if ($rootPath === null || $rootPath === '' || is_dir($rootPath) === false) {
            throw new TerminateException("File path not specified");
        }

        $this->scanAndSaveFiles($rootPath);
    }

    /**
     * Recursive scan
     * @param $path
     */
    protected function scanAndSaveFiles($path)
    {
        $files = scandir($path);

        if ($files === false) {
            return;
        }

        foreach ($files as $file) {
            if ($file === "." || $file === "..") {
                continue;
            }

            $file = $path . "/" . $file;

            if (is_dir($file)) {
                $this->scanAndSaveFiles($file);
                continue;
            }

            $this->addFile($file);
        }
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param $file
     * @return $this
     */
    protected function addFile($file)
    {
        if (file_exists($file)) {
            $this->files[] = $file;
        }

        return $this;
    }
}
