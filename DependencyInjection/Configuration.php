<?php

namespace Tecbot\AMFBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * AmfBundle configuration structure.
 *
 * @author Thomas Adam <thomas.adam@tecbot.de>
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
        $tb = new TreeBuilder();
        $rootNode = $tb->root('tecbot_amf');

        /*$rootNode
            ->children()
                ->booleanNode('test')->end()
            ->end()
        ;*/

        $this->addServicesSection($rootNode);
        $this->addMappingsSection($rootNode);

        return $tb;
    }

    private function addServicesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->fixXmlConfig('service')
            ->children()
                ->arrayNode('services')
                    ->useAttributeAsKey('alias')
                    ->prototype('array')
                        ->performNoDeepMerging()
                        ->beforeNormalization()->ifString()->then(function($v) { return array('class' => $v); })->end()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addMappingsSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->fixXmlConfig('mapping')
            ->children()
                ->arrayNode('mappings')
                    ->useAttributeAsKey('alias')
                    ->prototype('array')
                        ->performNoDeepMerging()
                        ->beforeNormalization()->ifString()->then(function($v) { return array('class' => $v); })->end()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}