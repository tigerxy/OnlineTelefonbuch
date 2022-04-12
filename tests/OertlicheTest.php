<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class OertlicheTest extends TestCase
{
    public function testQueryByPhoneNumber(): void
    {
        $o = new Oertliche();
        $contacts = $o->queryByPhoneNumber( "021163553355" );
        $this->assertCount(1, $contacts);

        $firstContact = $contacts[0];
        $this->assertEquals("Sipgate", $firstContact->getLastName());
    }
}