<?php

namespace Uneak\AssetsManagerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AssetsCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {
        if ($container->hasDefinition('uneak.assetsmanager') === false) {
            return;
        }
        $definition = $container->getDefinition('uneak.assetsmanager');
        $taggedServices = $container->findTaggedServiceIds('uneak.assetsmanager.assets');
		
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
					'addAssetsComponent', array(new Reference($id))
                );
            }
        }

    }

}
