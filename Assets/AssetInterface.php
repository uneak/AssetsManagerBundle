<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Templating\Helper\CoreAssetsHelper;

	interface AssetInterface {

		public function configureOptions(OptionsResolver $resolver);
		public function render(\Twig_Environment $twig, CoreAssetsHelper $assetsHelper, array $options);

	}
