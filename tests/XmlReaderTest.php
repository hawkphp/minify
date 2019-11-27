<?php

namespace Hawk\Tests\Psr7;

use Hawk\Minify\XmlReader;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlReaderTest
 * @package Hawk\Tests\Psr7
 */
class XmlReaderTest extends TestCase
{

    public function xmlFactory()
    {
        $xml = new XmlReader();
        $file = realpath(__DIR__) . '/config/minify.xml';
        $xml->load($file);

        return $xml;
    }

    public function testLoadXml()
    {
        $xml = $this->xmlFactory();
        $this->assertEquals('Minify code', $xml->getXml()->description);
    }
}
