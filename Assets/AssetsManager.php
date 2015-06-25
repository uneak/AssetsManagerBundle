<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsManager extends AssetsContainer {

		public function getAssetsArray($group = null) {
			$array = parent::getAssetsArray($group);
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