<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	interface AssetsComponentInterface {
        public function buildAsset(AssetBuilder $builder, $options);
        public function processBuildAssets(AssetBuilder $builder);
	}
