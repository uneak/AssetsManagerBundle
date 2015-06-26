<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AssetsManagerBundle\Assets\Asset;

	abstract class AssetExternal extends Asset {

        public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefined('class');
		}


	}