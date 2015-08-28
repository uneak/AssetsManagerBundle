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
        protected $assetTypeManager;

        public function __construct(AssetTypeManager $assetTypeManager) {
            $this->assetTypeManager = $assetTypeManager;
        }

		public function add($id, $object, array $parameters) {

            if (is_string($object)) {
                if (!$this->assetTypeManager->has($object)) {
                    throw new \Exception('AssetType not found for '.$object);
                }
                $object = $this->assetTypeManager->get($object);
            } else if (!$object instanceof AssetTypeInterface) {
                throw new \Exception($object.' is not AssetTypeInterface Class');
            }

            $resolver = new OptionsResolver();
            $object->configureOptions($resolver);
            $options = $resolver->resolve($parameters);
            $object->mergeToAssetsArray($this->assets, $id, new Asset($object, $options));

			return $this;
		}


        public function getAssets() {
            return $this->assets;
        }
        
        
	}