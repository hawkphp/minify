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
    private $fileFrom;

    /**
     * @var string|null
     */
    private $fileTo;

    /**
     * @var string
     */
    private $resource;

    /**
     * File constructor.
     * @param null $fileFrom
     * @param null $fileTo
     */
    public function __construct($fileFrom = null, $fileTo = null)
    {
        $this->fileFrom = $fileFrom;
        $this->fileTo = $fileTo;
    }

    /**
     * @return $this
     * @throws TerminateException
     */
    public function copy()
    {
        $pathTo = pathinfo($this->fileTo, PATHINFO_DIRNAME);

        if (!is_dir($pathTo)) {
            mkdir($pathTo, 0775, true);
        }

        if (!copy($this->fileFrom, $this->fileTo)) {
            throw new TerminateException('Error copying file');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function write()
    {
        if (!pathinfo($this->fileTo, PATHINFO_EXTENSION)) {
            throw new \InvalidArgumentException("Parameter 'pathTo' is not a file");
        }

        $pathTo = pathinfo($this->fileTo, PATHINFO_DIRNAME);

        if (!is_dir($pathTo)) {
            mkdir($pathTo, 0775, true);
        }

        file_put_contents($this->fileTo, $this->getResource());

        return $this;
    }

    /**
     * @return $this
     */
    public function read()
    {
        if (is_string($this->fileFrom) === false || $this->fileFrom === '') {
            throw new \InvalidArgumentException("File path is not a string or is empty");
        }

        if (file_exists($this->fileFrom) === false) {
            throw new \InvalidArgumentException(sprintf("Invalid file path %s", $this->fileFrom));
        }

        $this->resource = file_get_contents($this->fileFrom);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName()
    {
        return pathinfo($this->fileFrom, PATHINFO_BASENAME);
    }

    /**
     * @return string|null
     */
    public function getPath()
    {
        return pathinfo($this->fileFrom, PATHINFO_DIRNAME);
    }

    /**
     * @return string|null
     */
    public function getExt()
    {
        return pathinfo($this->fileFrom, PATHINFO_EXTENSION);
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
    public function getFileTo()
    {
        return $this->fileTo;
    }

    /**
     * @param $fileTo
     * @return $this
     */
    public function setFileTo($fileTo)
    {
        $this->fileTo = $fileTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileFrom()
    {
        return $this->fileFrom;
    }

    /**
     * @param $fileFrom
     * @return $this
     */
    public function setFileFrom($fileFrom)
    {
        $this->fileFrom = $fileFrom;
        return $this;
    }
}