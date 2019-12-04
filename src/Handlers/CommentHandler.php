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
 * Class CommentHandler
 * @package Hawk\Minify\Handlers
 */
class CommentHandler implements HandlerInterface
{
    /**
     * @param string $value
     * @return mixed
     */
    public function process($value)
    {
        return str_replace('(\/\/(.*?)(\n|$|\r|(\r\n)))|(\/\*(.*?)\*\/)', '', $value);
    }
}
