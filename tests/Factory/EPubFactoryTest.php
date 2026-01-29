<?php

namespace Rampmaster\PhpEpubBundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Rampmaster\EPub\Core\EPub;
use Rampmaster\PhpEpubBundle\Factory\EPubFactory;

class EPubFactoryTest extends TestCase
{
    private EPubFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new EPubFactory('en', '3.2');
    }

    public function testCreateDefaultEpub(): void
    {
        $epub = $this->factory->create();
        
        $this->assertInstanceOf(EPub::class, $epub);
    }

    public function testCreateEpub2(): void
    {
        $epub = $this->factory->createEpub2();
        
        $this->assertInstanceOf(EPub::class, $epub);
    }

    public function testCreateEpub3(): void
    {
        $epub = $this->factory->createEpub3();
        
        $this->assertInstanceOf(EPub::class, $epub);
    }

    public function testCreateEpub32(): void
    {
        $epub = $this->factory->createEpub32();
        
        $this->assertInstanceOf(EPub::class, $epub);
    }

    public function testCreateWithSpecificVersion(): void
    {
        $epub = $this->factory->create('3.1');
        
        $this->assertInstanceOf(EPub::class, $epub);
    }

    public function testCreateWithInvalidVersionDefaultsTo32(): void
    {
        $epub = $this->factory->create('invalid-version');
        
        // Invalid versions should default to EPUB 3.2
        $this->assertInstanceOf(EPub::class, $epub);
    }
}
