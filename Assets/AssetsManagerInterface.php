<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	interface AssetsManagerInterface {

		public function getAssets($group = null);
		public function addAssetsManager(AssetsManagerInterface $assetsManager);

	}
