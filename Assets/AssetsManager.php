<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;



	class AssetsManager extends AssetsComponentNested {

		protected $assetTypeManager;
		protected $registredAssets = array();
		protected $buildedAssets = array();

		public function __construct(AssetTypeManager $assetTypeManager, $configAssets) {
			$this->assetTypeManager = $assetTypeManager;
			foreach ($configAssets as $id => $asset) {
				$this->set($id, $asset, true);
			}
		}


		public function get($id) {
			if (!$this->has($id)) {
				// TODO lever une exeption
			}
			if (isset($this->buildedAssets[$id])) {
				return $this->buildedAssets[$id];
			} else if (isset($this->registredAssets[$id])) {
				return $this->registredAssets[$id];
			}
			return null;
		}

		public function set($id, $asset, $override = true) {
			if ($override || !$this->has($id)) {
				if ($asset['build']) {
					$this->buildedAssets[$id] = $asset;
				} else {
					$this->registredAssets[$id] = $asset;
				}
			}
			return $this;
		}

		public function has($id) {
			return (isset($this->buildedAssets[$id]) || isset($this->registredAssets[$id]));
		}

		public function remove($id) {
			if (isset($this->buildedAssets[$id])) {
				unset($this->buildedAssets[$id]);
			} else if (isset($this->registredAssets[$id])) {
				unset($this->registredAssets[$id]);
			}
			return $this;
		}



		public function buildAsset(AssetBuilder $builder, $parameters) {
			foreach ($this->buildedAssets as $id => $asset) {
				$builder->add($id, $asset['type'], $asset['config']);
			}
		}


		private function _fetchConfig($array) {
			$ret = array();
			foreach ($array as $key => $data) {
				if (is_array($data)) {
					if (isset($data['type'])) {
						$assetType = $data['type'];
						$config = (isset($data['config']) && is_array($data['config'])) ? $data['config'] : array();
						$ret[] = array(
							'id' => $key,
							'type' => $assetType,
							'config' => $config
						);
					}
				}
			}
			return $ret;
		}


		public function getAssetsArray($category = null) {

			$builder = new AssetBuilder($this->assetTypeManager);

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



//			if (isset($assetsConfig['register']) && is_array($assetsConfig['register'])) {
//				$assetsRegister = $this->_fetchConfig($assetsConfig['register']);
//				foreach ($assets as $key => $asset) {
//					if (isset($assetsRegister[$key])) {
//						$asset
//					}
//					$this->_resolveDependency($key, $assets, $resolved);
//				}
//
//			}


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