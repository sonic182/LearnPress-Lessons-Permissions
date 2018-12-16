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
		 */
		protected function _define_constants() {
			define( 'LP_LESSONS_PERMISSIONS_PATH', dirname( LP_ADDON_LESSONS_PERMISSIONS_FILE ) );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
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
			add_filter( 'learn-press/section-items', array( $this, 'section_items' ), 11 );
			add_filter( 'learn-press/single-course-request-item', array( $this, 'request_item' ), 11 );
		}


		public function admin_meta_box( $meta_boxes ) {

			$users = get_users( array( 'fields' => array( 'ID', 'user_email', 'user_login' )));

			$options = array(
				array(
					'name' => 'Restrict view',
					'id'   => "_lp_prerequisite_restrict_view",
					'type' => 'yes_no',
					'desc' => 'Restrict view to allowed users',
					'std'  => 'no'
				),
				array(
					'name'     => 'Allowed Users',
					'id'       => "_lp_allowed_users",
					'type'     => 'select_advanced',
					'multiple' => true,

					'desc'        => 'Allowed users for this lesson',
					'placeholder' => 'Select users',
					'std'         => '',
					'options'     => array()
				)
			);
			foreach($users as $user){
				$options[1]['options'][$user->ID] = $user->user_login . ' (' . $user->user_email . ')';
			}

			foreach ($options as $field){
				array_unshift( $meta_boxes['fields'], $field );
			}
			return $meta_boxes;
		}

		public function section_items( $items ) {
			if ( ! $items ) {
				return $items;
			}

			if (current_user_can('editor') || current_user_can('administrator')){
				return $items;
			}

			$res = array();

			foreach(array_keys($items) as $id){
				$restrict_users = get_post_meta($id, '_lp_prerequisite_restrict_view', true);

				if ($restrict_users == 'no'){
					$res[$id] = $items[$id];
				} else {
					$allowed_users = get_post_meta($id, '_lp_allowed_users');
					if (in_array(get_current_user_id(), $allowed_users)){
						$res[$id] = $items[$id];
					}
				}
			}
			return $res;
		}

		public function request_item( $item ) {
			if (!$item){
				return $item;
			}

			if (current_user_can('editor') || current_user_can('administrator')){
				return $item;
			}


			$id = $item->get_id();

			$restrict_users = get_post_meta($id, '_lp_prerequisite_restrict_view', true);

			if ($restrict_users == 'no'){
				return $item;
			} else {
				$allowed_users = get_post_meta($id, '_lp_allowed_users');
				if (in_array(get_current_user_id(), $allowed_users)){
					return $item;
				}
			}
			return null;
		}
	}
}

add_action( 'plugins_loaded', array( 'LP_Addon_Lessons_Permissions', 'instance' ) );
