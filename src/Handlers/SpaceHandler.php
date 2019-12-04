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
 * Class SpaceHandler
 * @package Hawk\Minify\Handlers
 */
class SpaceHandler implements HandlerInterface
{
    /**
     * @param string $value
     * @return mixed|string|string[]|null
     */
    public function process($value)
    {
        return preg_replace("/ {2,}/g", " ", $value);
    }
}
