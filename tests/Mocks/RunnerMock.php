<?php

namespace Hawk\Tests\Minify\Mocks;

use Hawk\Minify\Config;
use Hawk\Minify\Runner;

/**
 * Class RunnerMock
 * @package Hawk\Tests\Minify\Mocks
 */
class RunnerMock extends Runner
{
    /**
     * RunnerMock constructor.
     */
    public function __construct()
    {
        $config = new Config(__DIR__ . "/../assets/config/minify.xml");
        parent::__construct($config);
    }

    /**
     * @param string $filePath
     * @return mixed|string
     */
    public function getFilePathTo($filePath)
    {
        return parent::getFilePathTo($filePath);
    }
}