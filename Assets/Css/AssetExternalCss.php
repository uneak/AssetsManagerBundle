<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets\Css;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AdminBundle\Assets\AssetExternal;

	class AssetExternalCss extends AssetExternal {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

        public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setRequired('type');

			$resolver->setDefaults(array(
				"type" => "text/css",
				"rel" => "stylesheet",
				"tag" => "link",
				"group" => "AssetExternalCss",
			));

			$resolver->setDefined(array('rel', 'type', 'href', 'media', 'title'));
		}

		public function render(\Twig_Environment $twig, array $options) {
			$render = array();

			$render[] = '<' . $options['tag'];

			$params = array('href', 'rel', 'type', 'media');
			foreach ($params as $param) {
				if (isset($options[$param])) {
					$render[] = $param . '="' . $options[$param] . '"';
				}
			}

			$render[] = '/>';

			return implode(' ', $render);
		}


	}