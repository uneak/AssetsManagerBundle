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
			$array = array();
			$this->_mergeSelfAssetsArray($array, $group);
			$this->_mergeChildAssetsArray($array, $group);
			return $array;
			
		}

		protected function _mergeSelfAssetsArray(&$array, $group) {
			$assets = $this->_registerAssets();
			foreach ($assets as $key => $asset) {
				if ($group) {
					if ($asset->getGroup() == $group) {
						$array[$key] = $asset;
					}
				} else {
					$array[$key] = $asset;
				}
			}

		}

		protected function _mergeChildAssetsArray(&$array, $group) {
			foreach ($this->assetsContainers as $assetsContainer) {
				$groupAssets = $assetsContainer->getAssetsArray($group);
				foreach ($groupAssets as $key => $asset) {
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
		}


	}