<?php

namespace Hawk\Tests\Minify\Handlers;

/**
 * Class TestBarHandler
 * @package Hawk\Tests\Minify\Handlers
 */
class TestBarHandler
{

    /**
     * @param $value
     * @return mixed
     */
    public function cut($value)
    {
        return str_replace('Bar', '', $value);
    }
}