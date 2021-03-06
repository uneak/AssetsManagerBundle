<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Templating\Helper\CoreAssetsHelper;

	abstract class Asset implements AssetInterface {

		public function configureOptions(OptionsResolver $resolver) {

			$resolver->setDefined(array('tag', 'type', 'category', 'dependencies', 'parameters'));
			$resolver->setRequired(array('tag', 'category'));

			$resolver->setAllowedTypes('category', 'string');
			$resolver->setAllowedTypes('tag', 'string');
			$resolver->setAllowedTypes('dependencies', 'array');

			$resolver->setDefaults(array(
				'dependencies' => array(),
				'parameters' => array(),
			));



		}

		public function render(\Twig_Environment $twig, CoreAssetsHelper $assetsHelper, array $options) {
			return '';
		}


	}