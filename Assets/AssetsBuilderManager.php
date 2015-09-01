<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

    use Symfony\Component\OptionsResolver\OptionsResolver;

	class AssetsBuilderManager extends AssetsBuilderNested {

		protected $assets = array();
        protected $assetsManager;
        protected $assetTypeManager;


        public function __construct(AssetsManager $assetsManager, AssetTypeManager $assetTypeManager) {
            $this->assetsManager = $assetsManager;
            $this->assetTypeManager = $assetTypeManager;
        }


		public function add($id, $type = null, array $parameters = array()) {

            $assetArray = array("type" => $type, "build" => true, "config" => $parameters);

            if ($this->assetsManager->has($id)) {
                $registred = $this->assetsManager->get($id);
                $assetArray['type'] = $registred['type'];
                $assetArray['config'] = array_merge($assetArray['config'], $registred['config']);
            }

            if (is_string($assetArray['type'])) {
                if (!$this->assetTypeManager->has($assetArray['type'])) {
                    throw new \Exception('AssetType not found for '.$assetArray['type']);
                }
                $assetArray['type'] = $this->assetTypeManager->get($assetArray['type']);
            } else if (!$assetArray['type'] instanceof AssetTypeInterface) {
                throw new \Exception($assetArray['type'].' is not AssetTypeInterface Class');
            }

            $resolver = new OptionsResolver();
            $assetArray['type']->configureOptions($resolver);
            $options = $resolver->resolve($assetArray['config']);
            $assetArray['type']->mergeToAssetsArray($this->assets, $id, new Asset($assetArray['type'], $options));

			return $this;
		}


        public function getAssets($category = null) {
            $this->processBuildAssets($this);

            $assets = array();
            foreach ($this->assets as $itemKey => $item) {
                if (is_array($item)) {
                    $assets[$itemKey] = array();

                    foreach ($item as $assetItemKey => $assetItem) {
                        if (!$category || $assetItem->getCategory() == $category) {
                            $assets[$itemKey][$assetItemKey] = $assetItem;
                        }
                    }
                } else {
                    if (!$category || $item->getCategory() == $category) {
                        $assets[$itemKey] = $item;
                    }
                }
            }

            $resolved = array();
            foreach ($assets as $key => $asset) {
                $this->_resolveDependency($key, $assets, $resolved);
            }

            return $resolved;
        }


        public function processBuildAssets(AssetsBuilderManager $builder) {
            if ($this->isAssetsBuilded()) {
                return;
            }
            parent::processBuildAssets($builder);
        }

        public function buildAsset(AssetsBuilderManager $builder, $parameters) {
            if ($this->isAssetsBuilded()) {
                return;
            }

            $assets = $this->assetsManager->all();
            foreach ($assets as $id => $asset) {
                if (isset($asset["build"]) && $asset["build"] === true) {
                    $builder->add($id, $asset['type'], $asset['config']);
                }
            }
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