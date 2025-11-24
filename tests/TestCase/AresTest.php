<?php

namespace ADWS\Ares\Test\TestCase;

use ADWS\Ares\ES;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AresTest extends TestCase
{
    private ES $ares;

    protected function setUp(): void
    {
        $this->ares = new ES();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testValidIcoReturnsData()
    {
        $ico = '00025593';
        $data = $this->ares->fetch($ico);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('obchodniJmeno', $data);
        $this->assertArrayHasKey('ico', $data);
        $this->assertEquals($ico, $data['ico']);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testInvalidIcoThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->ares->fetch('123');
    }

    public function testNonExistentIcoThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->ares->fetch('00000000');
    }
}
