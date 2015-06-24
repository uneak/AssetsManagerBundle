<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	use Symfony\Component\OptionsResolver\OptionsResolver;

	abstract class Asset {

		protected $options;

		public function __construct(array $options = array()) {

			$resolver = new OptionsResolver();
			$this->configureOptions($resolver);
			$this->options = $resolver->resolve($options);

		}

		protected function configureOptions(OptionsResolver $resolver) {

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

		public function render(\Twig_Environment $twig) {
			return '';
		}

		public function getDependencies() {
			return $this->options['dependencies'];
		}

	}