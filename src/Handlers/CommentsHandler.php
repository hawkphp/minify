<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify\Handlers;

use Hawk\Minify\Interfaces\HandlerInterface;

/**
 * Class CommentsHandler
 * @package Hawk\Minify\Handlers
 */
class CommentsHandler implements HandlerInterface
{
    /**
     * Remove "*", "#", "//" php comments
     *
     * @param string $value
     * @return string
     */
    public function process($value)
    {
        $value = preg_replace('!/\*.*?\*/!s', " ", $value);
        $value = preg_replace("/\/\/ .*(\n|\r\n)/", " ", $value);

        return preg_replace("/# .*(\n|\r\n)/", " ", $value);
    }
}
