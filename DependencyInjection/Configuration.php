<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Black\Bundle\MenuBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
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

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
                ->children()
                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('menu_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('item_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('menu_manager')->defaultValue('Black\\Bundle\\MenuBundle\\Doctrine\\MenuManager')->end()
            ->end();

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
            ->end();
    }
}
