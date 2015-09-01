<?php

namespace Uneak\AssetsManagerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AssetsCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {
        if ($container->hasDefinition('uneak.assetsbuildermanager') === false || $container->hasDefinition('uneak.assettypemanager') === false) {
            return;
        }
        $assetsManagerDefinition = $container->getDefinition('uneak.assetsbuildermanager');
        $assetTypeManagerDefinition = $container->getDefinition('uneak.assettypemanager');

        $assetsManagerTaggedServices = $container->findTaggedServiceIds('uneak.assetsmanager.assets');
        $assetTypeManagerTaggedServices = $container->findTaggedServiceIds('uneak.assetsmanager.type');

        foreach ($assetsManagerTaggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $assetsManagerDefinition->addMethodCall(
					'addAssetsBuilder', array(new Reference($id))
                );
            }
        }

        foreach ($assetTypeManagerTaggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $assetTypeManagerDefinition->addMethodCall(
                    'add', array(new Reference($id), $attributes['id'])
                );
            }
        }

    }

}
