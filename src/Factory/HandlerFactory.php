<?php

namespace Hawk\Minify\Factory;

use Hawk\Minify\Handlers\BreakHandler;
use Hawk\Minify\Handlers\CommentsHandler;
use Hawk\Minify\Handlers\SpaceHandler;
use Hawk\Minify\Handlers\TabulationHandler;

/**
 * Class HandlersFactory
 * @package Hawk\Minify\Factory
 */
class HandlerFactory
{
    /**
     * @param string $name
     * @return BreakHandler|CommentsHandler|SpaceHandler|TabulationHandler
     */
    public function createHandler($name)
    {
        switch ($name) {
            case "space":
                return new SpaceHandler();
            case "break":
                return new BreakHandler();
            case "comments":
                return new CommentsHandler();
            case "tabulation":
                return new TabulationHandler();
            default:
        }

        throw new \InvalidArgumentException("Handler '{$name}' not found ");
    }
}
