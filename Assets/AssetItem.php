<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	class AssetItem {

		protected $object;
		protected $options;

		public function __construct(AssetInterface $object, array $options) {
            $this->object = $object;
            $this->options = $options;
		}

        /**
         * @return AssetInterface
         */
        public function getObject() {
            return $this->object;
        }

        /**
         * @return array
         */
        public function getOptions() {
            return $this->options;
        }

        public function getGroup() {
            return $this->options["group"];
        }

        public function getDependencies() {
            return $this->options["dependencies"];
        }

	}