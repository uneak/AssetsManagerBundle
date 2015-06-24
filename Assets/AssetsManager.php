<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsManager implements AssetsManagerInterface {

		protected $assetsManagers = array();

		public function addAssetsManager(AssetsManagerInterface $assetsManager) {
			array_push($this->assetsManagers, $assetsManager);
		}

		public function getAssets($group = null) {
			
			$array = array();
			foreach ($this->assetsManagers as $assetsManager) {
				$assets = $assetsManager->getAssets($group);
				foreach ($assets as $key => $asset) {
					if (is_array($asset)) {
						foreach ($asset as $assetItem) {
							if (!isset($array[$key])) {
								$array[$key] = $assetItem;
							} elseif (is_array($array[$key])) {
								array_push($array[$key], $assetItem);
							} else {
								$prevAsset = $array[$key];
								unset($array[$key]);
								$array[$key] = array($prevAsset, $assetItem);
							}
						}
					} else {
						if (!isset($array[$key])) {
							$array[$key] = $asset;
						} elseif (is_array($array[$key])) {
							array_push($array[$key], $asset);
						} else {
							$prevAsset = $array[$key];
							unset($array[$key]);
							$array[$key] = array($prevAsset, $asset);
						}
					}
				}
			}

			$resolved = array();
			foreach ($array as $key => $asset) {
				$this->_resolveDependency($key, $array, $resolved);
			}

			return $resolved;
			
		}


		private function _resolveDependency($key, &$array, &$resolved = array()) {
			//			if (!isset($array[$key])) {
			//				throw new NotFoundResourceException("L'asset ".$key." est manquante !");
			//			}

			if (isset($array[$key])) {
				if (is_array($array[$key])) {
					$dependencies = array();
					foreach ($array[$key] as $asset) {
						$assetDependency = $asset->getDependencies();
						if ($assetDependency && count($assetDependency)) {
							$dependencies = array_merge($dependencies, $assetDependency);
						}
					}
				} else {
					$dependencies = $array[$key]->getDependencies();
				}

				if ($dependencies) {
					foreach ($dependencies as $depKey => $dependency) {
						$this->_resolveDependency($dependency, $array, $resolved);
					}
				}

				$resolved[$key] = $array[$key];
				unset($array[$key]);
			}
		}


	}