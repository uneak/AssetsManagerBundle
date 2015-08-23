<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    interface AssetInterface {

		public function configureOptions(OptionsResolver $resolver);
		public function render(\Twig_Environment $twig, AssetsHelper $assetsHelper, TemplatesManager $templatesManager, array $options);

	}
