<?php

namespace Black\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_menu');

        $supportedDrivers = array('mongodb');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\'.')
                    ->end()
                ->end()

                ->scalarNode('menu_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('item_class')->isRequired()->cannotBeEmpty()->end()

            ->end()
        ;

        $this->addMenuSection($rootNode);

        return $treeBuilder;
    }

    private function addMenuSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('menu')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                        ->arrayNode('form')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('black_menu_menu_form')->end()
                                ->scalarNode('type')->defaultValue('Black\\Bundle\\MenuBundle\\Form\\Type\\MenuType')->end()
                                ->scalarNode('item_type')->defaultValue('Black\\Bundle\\MenuBundle\\Form\\Type\\ItemType')->end()
                                ->scalarNode('handler')->defaultValue('Black\\Bundle\\MenuBundle\\Form\\Handler\\MenuFormHandler')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
