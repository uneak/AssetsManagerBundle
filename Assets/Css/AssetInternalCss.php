<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets\Css;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AssetsManagerBundle\Assets\AssetInternal;

	class AssetInternalCss extends AssetInternal {

        public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefined('media');

			$resolver->setDefaults(array(
				"type" => "text/css",
				"tag" => "style",
				"category" => "AssetInternalCss",
			));


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


				return $twig->render(implode(' ', $render), $options['parameters']);

			} else if (isset($options['template'])) {

				return $twig->render($options['template'], $options['parameters']);

			}

			return '';

		}


	}