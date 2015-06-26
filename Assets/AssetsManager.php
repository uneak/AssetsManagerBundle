<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsManager extends AssetsComponentNested {


		public function getAssetsArray($category = null) {
			$builder = new AssetBuilder();
			$this->processBuildAssets($builder);
			$assets = $builder->getAssets();

			foreach ($assets as $itemKey => $item) {
				if (is_array($item)) {
					foreach ($item as $assetItemKey => $assetItem) {
						if ($assetItem->getCategory() != $category) {
							unset($assets[$itemKey][$assetItemKey]);
						}
					}
				} else {
					if ($item->getCategory() != $category) {
						unset($assets[$itemKey]);
					}
				}
			}

			$resolved = array();
			foreach ($assets as $key => $asset) {
				$this->_resolveDependency($key, $assets, $resolved);
			}

			return $resolved;
		}

		private function _resolveDependency($key, &$assets, &$resolved = array()) {
			//			if (!isset($array[$key])) {
			//				throw new NotFoundResourceException("L'asset ".$key." est manquante !");
			//			}

			if (isset($assets[$key])) {
				if (is_array($assets[$key])) {
					$dependencies = array();
					foreach ($assets[$key] as $asset) {
						$assetDependency = $asset->getDependencies();
						if ($assetDependency && count($assetDependency)) {
							$dependencies = array_merge($dependencies, $assetDependency);
						}
					}
				} else {
					$dependencies = $assets[$key]->getDependencies();
				}

				if ($dependencies) {
					foreach ($dependencies as $depKey => $dependency) {
						$this->_resolveDependency($dependency, $assets, $resolved);
					}
				}

				$resolved[$key] = $assets[$key];
				unset($assets[$key]);
			}
		}


	}