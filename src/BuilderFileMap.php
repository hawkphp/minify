<?php

namespace Hawk\Minify;

use Hawk\Minify\Exceptions\TerminateException;

/**
 * Class BuilderFileMap
 * @package Hawk\Minify
 */
class BuilderFileMap
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    private $files = [];

    /**
     * BuilderFileMap constructor.
     * @param $config
     * @throws TerminateException
     */
    public function __construct($config)
    {
        $this->config = $config;

        if (!is_array($this->config->extensions) || !count($this->config->extensions)) {
            throw new TerminateException("File extension not specified");
        }

        if ($this->config->pathFrom === null || $this->config->pathFrom === '') {
            throw new TerminateException("File path not specified");
        }
    }

    /**
     *
     */
    public function scan()
    {
        $this->scanAndSaveFiles($this->config->pathFrom);
    }

    /**
     * @param string $rootPath
     */
    protected function scanAndSaveFiles($rootPath)
    {
        $files = scandir($rootPath);

        foreach ($files as $file) {
            $filename = $rootPath . "/" . $file;

            if (is_dir($filename)) {
                $this->scanAndSaveFiles($filename);
                continue;
            }

            if ($this->isFileExtAllow($file) && file_exists($filename)) {
                $this->addFile($filename);
            }
        }
    }

    /**
     * @param $file
     * @return bool
     */
    protected function isFileExtAllow($file)
    {
        if (in_array($this->config->extensions, pathinfo($file, PATHINFO_EXTENSION))) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param string $file
     */
    protected function addFile($file)
    {
        if (file_exists($file)) {
            $this->files[] = $file;
        }
    }
}
