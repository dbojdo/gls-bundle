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
            ->arrayNode('accounts')
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('alias')
                ->prototype('array')
                    ->children()
                        ->scalarNode('ade_username')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('ade_password')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('ade_test_mode')->cannotBeEmpty()->defaultTrue()->end()
                        ->scalarNode('track_username')->cannotBeEmpty()->isRequired()->end()
                        ->scalarNode('track_password')->cannotBeEmpty()->isRequired()->end()
                    ->end()
                ->end()
            ->end()
            ->scalarNode('default_account')->cannotBeEmpty()->end()
        ->end();

        return $treeBuilder;
    }
}
