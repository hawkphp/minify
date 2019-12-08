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
use Hawk\Minify\Handlers\BreakHandler;
use Hawk\Minify\Handlers\CommentsHandler;
use Hawk\Minify\Handlers\SpaceHandler;
use Hawk\Minify\Handlers\TabulationHandler;

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

        if (in_array($file->getExt(), $this->config->extensions)) {
            $pipeline = new Pipeline($file->getResource(), 'process');
            $sizeBefore = mb_strlen($file->getResource());

            $pipeline->through(new CommentsHandler())
                ->through(new BreakHandler())
                ->through(new TabulationHandler())
                ->through(new SpaceHandler())
                ->run();

            $file->setResource($pipeline->getValue())->write();
            $sizeAfter = mb_strlen($pipeline->getValue());

            print(sprintf("Copied ... %s......%s [Before: %s, After: %s]" . PHP_EOL,
                $file->getFileName(),
                $this->getDots($filePathFrom),
                File::getSizeFormat($sizeBefore),
                File::getSizeFormat($sizeAfter)
            ));
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
     * @param string $filePath
     * @param null $path
     * @return string
     */
    protected function createFilePathTo($filePath, $path = null)
    {
        if ($path !== null) {
            return $path . "/" . $this->config->pathTo;
        }

        $path = is_null($path) ? realpath(__DIR__ . '/../../../../') : $path;
        $path .= "/" . $this->config->pathTo;

        return $path . str_replace($this->config->pathFrom, '', $filePath);
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
