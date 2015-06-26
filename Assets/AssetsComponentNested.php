<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsComponentNested extends AssetsComponent {

		protected $assetsComponents = array();

		public function addAssetsComponent(AssetsComponentInterface $assetsComponent) {
			array_push($this->assetsComponents, $assetsComponent);
		}

		public function removeAssetsComponent(AssetsComponentInterface $assetsComponent) {
			$index = array_search($assetsComponent, $this->assetsComponents);
			if ($index !== false) {
				array_splice($this->assetsComponents, $index, 1);
			}
		}

        protected function _processBuildChildAsset(AssetBuilder $builder) {
            foreach ($this->assetsComponents as $assetsComponent) {
                $assetsComponent->processBuildAssets($builder);
            }
        }

        protected function _processBuildSelfAsset(AssetBuilder $builder) {
            parent::processBuildAssets($builder);
        }

        public function processBuildAssets(AssetBuilder $builder) {
            $this->_processBuildSelfAsset($builder);
            $this->_processBuildChildAsset($builder);
        }
	}