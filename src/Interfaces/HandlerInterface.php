<?php

/**
 * Prepare deploy 2019
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
    public function findAndClear();
}
