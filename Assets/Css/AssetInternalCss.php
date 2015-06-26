<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets\Css;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AdminBundle\Assets\AssetInternal;

	class AssetInternalCss extends AssetInternal {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

        public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefaults(array(
				"type" => "text/css",
				"tag" => "style",
				"group" => "AssetInternalCss",
			));

			$resolver->setDefined('media');
		}


		public function render(\Twig_Environment $twig, array $options) {

			if (isset($options['content'])) {

				$render = array();
				$render[] = '<' . $options['tag'];
				$params = array('type', 'media');
				foreach ($params as $param) {
					if (isset($options[$param])) {
						$render[] = $param . '="' . $options[$param] . '"';
					}
				}
				$render[] = '>';
				$render[] = $options['content'];
				$render[] = '</' . $options['tag'] . '>';

				return implode(' ', $render);

			} else if (isset($options['template'])) {

				return $twig->render($options['content'], $options['parameters']);

			}

			return '';

		}


	}