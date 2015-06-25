<?php

namespace Uneak\AssetsManagerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Uneak\AssetsManagerBundle\DependencyInjection\Compiler\AssetsCompilerPass;

class UneakAssetsManagerBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new AssetsCompilerPass());
	}

}
