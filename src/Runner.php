<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify;

use Hawk\Minify\Factory\HandlerFactory;

/**
 * Class Runner
 * @package Hawk\Minify
 */
class Runner
{
    /**
     * @var Config|null
     */
    private $config;

    /**
     * Runner constructor.
     * @param  Config|null $config
     */
    public function __construct($config = null)
    {
        $this->config = $config;
    }

    /**
     * @throws Exceptions\TerminateException
     */
    public function toBegin()
    {
        $builder = new FileMapBuilder();
        $builder->scan($this->config->pathFrom);
        $files = $builder->getFiles();

        if (is_array($files) && count($files) > 0) {
            foreach ($builder->getFiles() as $file) {
                $this->processAndCopy($file);
            }
        }
    }

    /**
     * @param $filePath
     * @throws Exceptions\TerminateException
     */
    protected function processAndCopy($filePath)
    {
        $file = new File($filePath, $this->getFilePathTo($filePath));
        $file->read();

        if (in_array($file->getExt(), $this->config->extensions) && is_array($this->config->handlers)) {
            $handlerFactory = new HandlerFactory();
            $pipeline = new Pipeline($file->getExt(), 'findAndClear');
            if (is_array($this->config->handlers) && count($this->config->handlers) > 0) {
                foreach ($this->config->handlers as $index => $name) {
                    $pipeline->through($handlerFactory->createHandler($name));
                }

                $pipeline->run();
                $file->setResource($pipeline->getValue())->write();
            }
        } else {
            $file->copy();
        }
    }

    /**
     * @param string $filePath
     * @param null $path
     * @return string
     */
    protected function getFilePathTo($filePath, $path = null)
    {
        $path = is_null($path) ? realpath(__DIR__ . '/../../../') : $path;
        $path .= $this->config->pathTo . "/";

        return $path . pathinfo($filePath, PATHINFO_BASENAME);
    }

    /**
     * @param $file
     * @return bool
     */
    protected function isAllowFileExt($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if (in_array($ext, $this->config->extensions)) {
            return true;
        }

        return false;
    }
}
