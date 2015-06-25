<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsContainer implements AssetsContainerInterface {

		protected $assetsContainers = array();

		protected function _registerAssets() {
			return array();
		}

		public function addAssetsContainer(AssetsContainerInterface $assetsContainer) {
			array_push($this->assetsContainers, $assetsContainer);
		}

		public function removeAssetsContainer(AssetsContainerInterface $assetsContainer) {
			$index = array_search($assetsContainer, $this->assetsContainers);
			if ($index !== false) {
				array_splice($this->assetsContainers, $index, 1);
			}
		}

		public function getAssetsArray($group = null) {
			$assets = $this->_registerAssets();
			$array = array();
			$this->_mergeSelfAssetsArray($assets, $array, $group);

			foreach ($this->assetsContainers as $assetsContainer) {
				$assets = $assetsContainer->getAssetsArray($group);
				$this->_mergeGroupAssetsArray($assets, $array);
			}

			return $array;
		}


		protected function _mergeSelfAssetsArray($assets, &$array, $group) {
			foreach ($assets as $key => $asset) {
				if ($group) {
					if ($asset->getGroup() == $group) {
						$this->_addAssetToArray($key, $asset, $array);
					}
				} else {
					$this->_addAssetToArray($key, $asset, $array);
				}
			}
		}

		protected function _mergeGroupAssetsArray($assets, &$array) {
			foreach ($assets as $key => $asset) {
				if (is_array($asset)) {
					foreach ($asset as $assetItem) {
						$this->_addAssetToArray($key, $asset, $array);
					}
				} else {
					$this->_addAssetToArray($key, $asset, $array);
				}
			}
		}


		protected function _addAssetToArray($key, $asset, &$array) {
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