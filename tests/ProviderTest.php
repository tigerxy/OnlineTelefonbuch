<?php

use PHPUnit\Framework\TestCase;

class ProviderTest extends TestCase
{
    public function testGetXML()
    {
        $provider = new Oertliche();
        $xml = $provider->getXML([
            new Contact(),
            new Contact(),
            new Contact(),
        ]);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertEquals("3", $xml->xpath("/list/@total")[0]);
    }

    public function testGetXMLEmptyResult()
    {
        $provider = new Oertliche();
        $xml = $provider->getXML([]);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertEquals("0", $xml->xpath("/list/@total")[0]);
    }
}
