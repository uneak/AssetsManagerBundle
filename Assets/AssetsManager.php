<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 29/01/15
 * Time: 16:13
 */

namespace Uneak\AssetsManagerBundle\Assets;


class AssetsManager extends AssetsComponent
{


    public function getAssetsArray($group = null)
    {
        $builder = new AssetBuilder();
        $this->processBuildAssets($builder);

        $assets = $builder->getAssets($group);

        $array = array();
        foreach ($assets as $item) {
            if (is_array($item)) {
                foreach ($item as $assetItem) {
                    if ($assetItem->getGroup() != $group) {
                        unset($assetItem);
                    }
                }
            } else {
                if ($item->getGroup() != $group) {
                    unset($assetItem);
                }
            }
        }


        $resolved = array();
        foreach ($array as $key => $asset) {
            $this->_resolveDependency($key, $array, $resolved);
        }
        return $resolved;
    }

    private function _resolveDependency($key, &$array, &$resolved = array())
    {
        //			if (!isset($array[$key])) {
        //				throw new NotFoundResourceException("L'asset ".$key." est manquante !");
        //			}

        if (isset($array[$key])) {
            if (is_array($array[$key])) {
                $dependencies = array();
                foreach ($array[$key] as $asset) {
                    $assetDependency = $asset->getDependencies();
                    if ($assetDependency && count($assetDependency)) {
                        $dependencies = array_merge($dependencies, $assetDependency);
                    }
                }
            } else {
                $dependencies = $array[$key]->getDependencies();
            }

            if ($dependencies) {
                foreach ($dependencies as $depKey => $dependency) {
                    $this->_resolveDependency($dependency, $array, $resolved);
                }
            }

            $resolved[$key] = $array[$key];
            unset($array[$key]);
        }
    }



}