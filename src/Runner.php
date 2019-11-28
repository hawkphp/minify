<?php

namespace Hawk\Minify;

/**
 * Class Runner
 * @package Hawk\Minify
 */
class Runner
{
    /**
     * @var
     */
    private $config;

    /**
     * Runner constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @throws Exceptions\TerminateException
     */
    public function toBegin()
    {
        $builder = new BuilderFileMap($this->config);
        $builder->scan();
    }
}
