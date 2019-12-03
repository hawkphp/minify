<?php

namespace Hawk\Tests\Minify\Handlers;

/**
 * Class TestBazHandler
 * @package Hawk\Tests\Minify\Handlers
 */
class TestBazHandler
{

    /**
     * @param $value
     * @return mixed
     */
    public function cut($value)
    {
        return str_replace('Baz', '', $value);
    }
}