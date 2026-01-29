<?php

namespace Rampmaster\PhpEpubBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Get the configuration tree builder
     *
     * Defines the bundle configuration structure:
     * - default_language: Default language for EPUB books (default: 'en')
     * - default_version: Default EPUB version (2.0.1, 3.0, 3.0.1, 3.1, or 3.2, default: '3.2')
     *
     * @return TreeBuilder The configuration tree
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('rampmaster_php_epub');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_language')
                    ->defaultValue('en')
                    ->info('Default language for EPUB books')
                ->end()
                ->enumNode('default_version')
                    ->values(['2.0.1', '3.0', '3.0.1', '3.1', '3.2'])
                    ->defaultValue('3.2')
                    ->info('Default EPUB version')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
