<?php

	namespace Uneak\AssetsManagerBundle\Assets;

    use Symfony\Component\OptionsResolver\OptionsResolver;

	interface AssetInterface {

        public function configureOptions(OptionsResolver $resolver);
        public function render(\Twig_Environment $twig, array $options);

	}
