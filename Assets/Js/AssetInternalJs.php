<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets\Js;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AdminBundle\Assets\AssetInternal;

	class AssetInternalJs extends AssetInternal {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		protected function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefaults(array(
				"type" => "text/javascript",
				"tag" => "script",
				"group" => "AssetInternalJs",
			));

		}


		public function render(\Twig_Environment $twig) {

			if (isset($this->options['content'])) {

				$render = array();
				$render[] = '<' . $this->options['tag'];
				$params = array('type');
				foreach ($params as $param) {
					if (isset($this->options[$param])) {
						$render[] = $param . '="' . $this->options[$param] . '"';
					}
				}
				$render[] = '>';
				$render[] = $this->options['content'];
				$render[] = '</' . $this->options['tag'] . '>';

				return implode(' ', $render);

			} else if (isset($this->options['template'])) {

				return $twig->render($this->options['content'], $this->options['parameters']);

			}

			return '';

		}


	}