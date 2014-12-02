<?php
/**
 * Configuration.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 12:46
 */
namespace Webit\Bundle\GlsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Webit\Bundle\GlsBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('webit_gls');

        $root
        ->children()
            ->arrayNode('ade_accounts')
                ->useAttributeAsKey('alias')
                ->prototype('array')
                    ->children()
                        ->scalarNode('username')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('password')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('ade_test_mode')->cannotBeEmpty()->defaultTrue()->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('track_accounts')
                ->useAttributeAsKey('alias')
                ->prototype('array')
                    ->children()
                        ->scalarNode('username')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('password')->cannotBeEmpty()->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
