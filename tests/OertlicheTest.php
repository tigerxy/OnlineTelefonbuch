<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class OertlicheTest extends TestCase
{
    public function testQueryByHomeNumber(): void
    {
        $phoneNumberToTest = "0123456789";

        $network = $this->getMockBuilder(HTTPClient::class)
            ->setMethods(["get"])
            ->getMock();

        $network->method('get')->willReturn(
            <<<EOD
            var handlerData =[["0123456789","fhfghfgh","","",
            null,"Berlin","","0","0","0","0","0","0","0","Mustermann Max",
            "https://www.dasoertliche.de/Themen/xxx","1"]];
            EOD
        );

        $provider = new Oertliche($network);
        $contacts = $provider->queryByHomeNumber($phoneNumberToTest);
        $this->assertCount(1, $contacts);

        $firstContact = $contacts[0];
        $this->assertEquals("Max", $firstContact->getFirstName());
        $this->assertEquals("Mustermann", $firstContact->getLastName());
        $this->assertEquals($phoneNumberToTest, $firstContact->getHomeNumber());
    }
}