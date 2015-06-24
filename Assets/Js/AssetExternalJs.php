<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets\Js;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AdminBundle\Assets\AssetExternal;

	class AssetExternalJs extends AssetExternal {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		protected function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setRequired('type');

			$resolver->setDefaults(array(
				"type" => "text/javascript",
				"tag" => "script",
				"group" => "AssetExternalJs",
			));

			$resolver->setDefined(array('src', 'charset', 'language', 'defer', 'event', 'for'));
		}


		public function render(\Twig_Environment $twig) {
			$render = array();

			$render[] = '<' . $this->options['tag'];

			$params = array('src', 'type', 'class', 'charset', 'language', 'defer', 'event', 'for');
			foreach ($params as $param) {
				if (isset($this->options[$param])) {
					$render[] = $param . '="' . $this->options[$param] . '"';
				}
			}

			$render[] = '/>';

			return implode(' ', $render);
		}

	}