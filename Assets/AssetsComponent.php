<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsComponent implements AssetsComponentInterface {

        public function buildAsset(AssetBuilder $builder, $parameters) {
		}

        public function processBuildAssets(AssetBuilder $builder) {
			$this->buildAsset($builder, $this);
        }
	}