<?php

namespace Hawk\Minify;

/**
 * Class XmlReader
 * @package Hawk\Minify
 */
class XmlReader
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * XmlReader constructor.
     * @param null $path
     */
    public function __construct($path = null)
    {
        if ($path !== null) {
            $this->load($path);
        }
    }

    /**
     * @param $filePath
     * @return $this
     */
    public function load($filePath)
    {
        if (file_exists($filePath) === false) {
            throw new \InvalidArgumentException(sprintf("File %s not found", $filePath));
        }

        $this->xml = simplexml_load_file($filePath);

        return $this;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param $name
     * @return \SimpleXMLElement
     */
    public function getElement($name)
    {
        return $this->xml->$name;
    }

    /**
     * @param $name
     * @return int count the children of elements
     */
    public function hasElement($name)
    {
        return $this->xml->{$name}->count();
    }
}
