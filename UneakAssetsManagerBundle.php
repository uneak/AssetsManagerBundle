<?php

namespace Uneak\AssetsManagerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\AdminBundle\DependencyInjection\Compiler\FormCompilerPass;
use Uneak\AdminBundle\DependencyInjection\Compiler\NestedRouteCompilerPass;
use Uneak\AdminBundle\DependencyInjection\Compiler\BlockCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UneakAssetsManagerBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
	}

}
