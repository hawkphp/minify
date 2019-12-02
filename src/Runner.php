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
        $file = new File($filePath, $this->getNewFilePath($filePath));
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
     * @return string
     */
    protected function getNewFilePath($filePath)
    {
        $path = realpath(__DIR__ . '/../../../') . $this->config->pathTo . "/";
        $path .= pathinfo($filePath, PATHINFO_FILENAME);


        return $path . pathinfo($filePath, PATHINFO_FILENAME);
    }

    /**
     * @param $file
     * @return bool
     */
    protected function isFileExtAllow($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if (in_array($this->config->extensions, $ext)) {
            return true;
        }

        return false;
    }


}
