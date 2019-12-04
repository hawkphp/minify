<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org/
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify\Interfaces;

/**
 * Interface HandlerInterface
 * @package Hawk\Minify\Interfaces
 */
interface HandlerInterface
{
    /**
     * @param string $value
     * @return mixed
     */
    public function process($value);
}
