<?php

namespace Hawk\Tests\Minify\Handlers;

/**
 * Class TestFooHandler
 * @package Hawk\Tests\Minify\Handlers
 */
class TestFooHandler
{

    /**
     * @param $value
     * @return mixed
     */
    public function cut($value)
    {
        return str_replace('Foo', '', $value);
    }
}