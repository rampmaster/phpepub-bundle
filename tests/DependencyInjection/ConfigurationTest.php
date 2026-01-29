<?php

namespace Rampmaster\PhpEpubBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Rampmaster\PhpEpubBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), []);

        $this->assertSame('en', $config['default_language']);
        $this->assertSame('3.2', $config['default_version']);
    }

    public function testCustomConfiguration(): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), [
            'rampmaster_php_epub' => [
                'default_language' => 'es',
                'default_version' => '3.0',
            ]
        ]);

        $this->assertSame('es', $config['default_language']);
        $this->assertSame('3.0', $config['default_version']);
    }

    public function testInvalidVersionThrowsException(): void
    {
        $this->expectException(\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException::class);

        $processor = new Processor();
        $processor->processConfiguration(new Configuration(), [
            'rampmaster_php_epub' => [
                'default_version' => 'invalid',
            ]
        ]);
    }
}
