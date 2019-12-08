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
 * Class TabulationHandler
 * @package Hawk\Minify\Handlers
 */
class TabulationHandler implements HandlerInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function process($value)
    {
        return trim(preg_replace('/\t+/', " ", $value));
    }
}
