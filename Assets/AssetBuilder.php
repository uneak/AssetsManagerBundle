<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

    use Symfony\Component\OptionsResolver\OptionsResolver;

	class AssetBuilder {

		protected $assets = array();

        public function __construct() {
        }

		public function add($id, AssetInterface $object, array $parameters) {
            $resolver = new OptionsResolver();
            $object->configureOptions($resolver);
            $options = $resolver->resolve($parameters);
            $this->_addAssetToArray($id, new AssetItem($object, $options));
			return $this;
		}


        protected function _addAssetToArray($key, $asset) {
            if (!isset($this->assets[$key])) {
                $this->assets[$key] = $asset;
            } elseif (is_array($this->assets[$key])) {
                array_push($this->assets[$key], $asset);
            } else {
                $prevAsset = $this->assets[$key];
                unset($this->assets[$key]);
                $this->assets[$key] = array($prevAsset, $asset);
            }
        }


        public function getAssets() {
            return $this->assets;
        }
        
        
	}