<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify;

use Hawk\Minify\Factory\FileFactory;
use Hawk\Minify\Factory\HandlerFactory;

/**
 * Class Runner
 * @package Hawk\Minify
 */
class Runner
{
    private $maxLength = 0;
    /**
     * @var Config|null
     */
    private $config;

    /**
     * Runner constructor.
     * @param Config|null $config
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
        foreach ($files as $file) {
            $file = pathinfo($file, PATHINFO_BASENAME);
            if (mb_strlen($file) > $this->maxLength) {
                $this->maxLength = mb_strlen($file);
            }
        }

        if (is_array($files) && count($files) > 0) {
            foreach ($builder->getFiles() as $file) {
                $this->process($file);
            }
        }
    }

    /**
     * @param $filePathFrom
     * @throws Exceptions\TerminateException
     */
    protected function process($filePathFrom)
    {
        $file = (new FileFactory())->createFile($filePathFrom, $this->createFilePathTo($filePathFrom));

        if (in_array($file->getExt(), $this->config->extensions) && is_array($this->config->handlers)) {
            $handlerFactory = new HandlerFactory();
            $pipeline = new Pipeline($file->getExt(), 'process');

            if (is_array($this->config->handlers) && count($this->config->handlers) > 0) {
                $sizeBefore = mb_strlen($file->getResource());
                foreach ($this->config->handlers as $index => $name) {
                    $pipeline->through($handlerFactory->createHandler($name));
                }
                $pipeline->run();

                $file->setResource($pipeline->getValue())->write();
                $sizeAfter = mb_strlen($pipeline->getValue());

                print(sprintf("Copied ... %s......%s [Before: %s, After: %s]" . PHP_EOL,
                    $file->getFileName(),
                    $this->getDots($filePathFrom),
                    $this->getFormat($sizeBefore),
                    $this->getFormat($sizeAfter)
                ));
            }
        } else {
            $file->copy();
            print(sprintf("Copied ... %s \n", $file->getFileName()));
        }
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getDots($filename)
    {
        $filename = pathinfo($filename, PATHINFO_BASENAME);
        $length = mb_strlen($filename);

        if ($length < $this->maxLength) {
            $fillCount = $this->maxLength - $length;

            return str_repeat(".", $fillCount);
        }
        return '';
    }


    /**
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public function getFormat($bytes, $precision = 2)
    {
        $units = array('b', 'kb', 'mb', 'gb');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes, $precision) . $units[$pow];
    }

    /**
     * @param string $filePath
     * @param null $path
     * @return string
     */
    protected function createFilePathTo($filePath, $path = null)
    {
        $path = is_null($path) ? realpath(__DIR__ . '/../../../../') : $path;
        $path .= "/" . $this->config->pathTo . "/";

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
