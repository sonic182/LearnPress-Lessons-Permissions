<?php
/**
 * Plugin load class.
 *
 * @author   Johanderson Mogollon
 * @package  LearnPress/Lessons-Permissions/Classes
 * @version  0.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_Lessons_Permissions' ) ) {
	/**
	 * Class LP_Addon_Lessons_Permissions
	 */
	class LP_Addon_Lessons_Permissions extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_LESSONS_PERMISSIONS_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_LESSONS_PERMISSIONS_REQUIRE_VER;

		/**
		 * LP_Addon_Lessons_Permissions constructor.
		 */
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Define Learnpress Prerequisites Courses constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			define( 'LP_LESSONS_PERMISSIONS_PATH', dirname( LP_ADDON_LESSONS_PERMISSIONS_FILE ) );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 3.0.0
		 */
		protected function _includes() {
			// code
		}

		/**
		 * Hook into actions and filters.
		 */
		protected function _init_hooks() {
			// add selector to lesson meta box
			add_filter( 'learn_press_lesson_meta_box_args', array( $this, 'admin_meta_box' ), 11 );
		}

		/**
		 * Add prerequisites courses in course meta box.
		 *
		 * @since 3.0.0
		 *
		 * @param $meta_boxes
		 *
		 * @return mixed
		 */

		public function admin_meta_box( $meta_boxes ) {

		}
	}
}

add_action( 'plugins_loaded', array( 'LP_Addon_Lessons_Permissions', 'instance' ) );
