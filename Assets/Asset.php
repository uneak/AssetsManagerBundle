<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

    use Symfony\Component\OptionsResolver\OptionsResolver;

	abstract class Asset implements AssetInterface {

		protected $options;

		public function __construct() {
		}

		public function configureOptions(OptionsResolver $resolver) {

			$resolver->setRequired(array('tag', 'group'));

			$resolver->setAllowedTypes('group', 'string');
			$resolver->setAllowedTypes('tag', 'string');
			$resolver->setAllowedTypes('dependencies', 'array');

			$resolver->setDefaults(array(
				'dependencies' => array(),
				'parameters' => array(),
			));

			$resolver->setDefined(array('tag', 'type', 'group', 'dependencies', 'parameters'));

		}

		public function render(\Twig_Environment $twig, array $options) {
			return '';
		}

		public function getDependencies() {
			return $this->options['dependencies'];
		}

		public function getGroup() {
			return $this->options['group'];
		}

	}