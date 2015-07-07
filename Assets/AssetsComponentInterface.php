<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	interface AssetsComponentInterface {
        public function buildAsset(AssetBuilder $builder, $parameters);
        public function processBuildAssets(AssetBuilder $builder);
	}
