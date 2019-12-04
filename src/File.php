<?php

namespace Hawk\Minify;

use Hawk\Minify\Exceptions\TerminateException;

/**
 * Class File
 * @package Hawk\Minify
 */
class File
{
    /**
     * @var string|null
     */
    private $filePathFrom;

    /**
     * @var string|null
     */
    private $filePathTo;

    /**
     * @var resource|string
     */
    private $resource;

    /**
     * File constructor.
     * @param string|null $filePathFrom
     * @param string|null $filePathTo
     */
    public function __construct($filePathFrom = null, $filePathTo = null)
    {
        $this->filePathFrom = $filePathFrom;
        $this->filePathTo = $filePathTo;
    }

    /**
     * @return $this
     * @throws TerminateException
     */
    public function copy()
    {
        $pathTo = pathinfo($this->filePathTo, PATHINFO_DIRNAME);

        if (!is_dir($pathTo)) {
            mkdir($pathTo, 0775, true);
        }

        if (!copy($this->filePathFrom, $this->filePathTo)) {
            throw new TerminateException('Error copying file');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function write()
    {
        if (!pathinfo($this->filePathTo, PATHINFO_EXTENSION)) {
            throw new \InvalidArgumentException("Parameter 'pathTo' is not a file");
        }

        $pathTo = pathinfo($this->filePathTo, PATHINFO_DIRNAME);

        if (!is_dir($pathTo)) {
            mkdir($pathTo, 0775, true);
        }

        file_put_contents($this->filePathTo, $this->getResource());

        return $this;
    }

    /**
     * @return $this
     */
    public function read()
    {
        if (is_string($this->filePathFrom) === false || $this->filePathFrom === '') {
            throw new \InvalidArgumentException("File path is not a string or is empty");
        }

        if (file_exists($this->filePathFrom) === false) {
            throw new \InvalidArgumentException(sprintf("Invalid file path %s", $this->filePathFrom));
        }

        $this->resource = file_get_contents($this->filePathFrom);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName()
    {
        return pathinfo($this->filePathFrom, PATHINFO_BASENAME);
    }

    /**
     * @return string|null
     */
    public function getPath()
    {
        return pathinfo($this->filePathFrom, PATHINFO_DIRNAME);
    }

    /**
     * @return string|null
     */
    public function getExt()
    {
        return pathinfo($this->filePathFrom, PATHINFO_EXTENSION);
    }

    /**
     * @param $resource
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string|null
     */
    public function getFilePathTo()
    {
        return $this->filePathTo;
    }

    /**
     * @param $filePathTo
     * @return $this
     */
    public function setFilePathTo($filePathTo)
    {
        $this->filePathTo = $filePathTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilePathFrom()
    {
        return $this->filePathFrom;
    }

    /**
     * @param $filePathFrom
     * @return $this
     */
    public function setFilePathFrom($filePathFrom)
    {
        $this->filePathFrom = $filePathFrom;
        return $this;
    }
}
