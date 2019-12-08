<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\XmlReader;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlReaderTest
 * @package Hawk\Tests\Psr7
 */
class XmlReaderTest extends TestCase
{

    public function getXmlReaderFactory()
    {
        $xml = new XmlReader();
        $file = realpath(__DIR__) . '/assets/config/minify.xml';
        $xml->load($file);

        return $xml;
    }

    public function testLoadXml()
    {
        $xml = $this->getXmlReaderFactory();
        $this->assertEquals('Minify code', $xml->getXml()->description);
    }

    public function testConfigElementPaths()
    {
        $xml = $this->getXmlReaderFactory();
        $this->assertEquals("src", $xml->getXml()->pathFrom);
        $this->assertEquals("deploy", $xml->getXml()->pathTo);
    }

    public function testConfigElementExtensions()
    {
        $xml = $this->getXmlReaderFactory();

        $this->assertEquals(array(
            'php',
            'js',
            'css'
        ), $xml->toArray('extensions', 'ext'));
    }

    public function testHasElement()
    {
        $xml = $this->getXmlReaderFactory();

        $this->assertTrue($xml->hasElement('pathFrom'));
        $this->assertFalse($xml->hasElement('pathFake'));
    }

    public function testToArray()
    {
        $xml = $this->getXmlReaderFactory();
        $handlers = $xml->toArray('extensions', 'ext');
        $this->assertEquals(array('php', 'js', 'css'), $handlers);
    }
}
