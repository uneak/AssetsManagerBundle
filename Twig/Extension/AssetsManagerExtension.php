<?php

	namespace Uneak\AssetsManagerBundle\Twig\Extension;

	use Symfony\Component\DependencyInjection\ContainerInterface;
	use Twig_Extension;
	use Twig_Function_Method;
	use Uneak\AssetsManagerBundle\Assets\AssetsManager;

	class AssetsManagerExtension extends Twig_Extension {

		private $twig;
		private $environment;
		private $assetsManager;
		private $container;

		public function __construct(AssetsManager $assetsManager, $twig, ContainerInterface $container) {
			$this->assetsManager = $assetsManager;
			$this->twig = $twig;
			$this->container = $container;
		}

		public function initRuntime(\Twig_Environment $environment) {
			$this->environment = $environment;
		}

		public function getFunctions() {
			$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

			return array(
				'renderAssets'   => new Twig_Function_Method($this, 'renderAssetsFunction', $options)
			);
		}

		public function renderAssetsFunction($category = null) {
			$string = "";
			$assets = $this->assetsManager->getAssetsArray($category);
			$assetsHelper = $this->container->get('templating.helper.assets');

			foreach ($assets as $asset) {

				if (is_array($asset)) {
					foreach ($asset as $assetItem) {
						$string .= $assetItem->getObject()->render($this->twig, $assetsHelper, $assetItem->getOptions());
					}
				} else {
					$string .= $asset->getObject()->render($this->twig, $assetsHelper, $asset->getOptions());
				}
			}

			return $string;
		}

		public function getName() {
			return 'uneak_assetsmanager';
		}

	}
