<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;



	class AssetsManager {

		protected $assetTypeManager;
		protected $assets = array();

		public function __construct(AssetTypeManager $assetTypeManager, $configAssets) {
			$this->assetTypeManager = $assetTypeManager;
			foreach ($configAssets as $id => $assetArray) {
				$this->set($id, $assetArray, true);
			}
		}

		public function get($id) {
			if (!$this->has($id)) {
				// TODO lever une exeption
			}
			if (isset($this->assets[$id])) {
				return $this->assets[$id];
			}
			return null;
		}

		public function set($id, $assetArray, $override = true) {
			if ($override || !$this->has($id)) {
				$this->assets[$id] = $assetArray;
			}
			return $this;
		}

		public function all() {
			return $this->assets;
		}

		public function has($id) {
			return isset($this->assets[$id]);
		}

		public function remove($id) {
			unset($this->assets[$id]);
			return $this;
		}

	}