<?php

namespace Hawk\Minify;

use Hawk\Minify\Exceptions\TerminateException;

/**
 * Class MinifyStarter
 * @package Hawk\Minify
 */
class MinifyStarter
{
    const SEPARATOR = "=========================================================";

    /**
     *
     * @throws \Exception
     */
    public function squeeze()
    {
        try {
            $this->checkRequirements();
        } catch (\Exception $e) {
            echo $e->getMessage();
            throw $e;
        }

        $runner = new Runner();
        $runner->init();
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return self::SEPARATOR . PHP_EOL;
    }

    /**
     * @throws \Exception
     */
    private function checkRequirements()
    {
        if (extension_loaded("SimpleXML") === false) {
            throw new TerminateException(
                "The SimpleXML extension to be enabled." . PHP_EOL
            );
        }

        if (PHP_VERSION_ID < 50500) {
            throw new TerminateException(
                'Minify requires PHP version 5.5 or greater.' . PHP_EOL
            );
        }
    }
}
