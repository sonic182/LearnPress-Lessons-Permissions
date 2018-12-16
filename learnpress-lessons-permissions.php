<?php
/*
Plugin Name: LearnPress - Lessons Permissions
Plugin URI: http://thimpress.com/learnpress
Description: Lessons you can allow/disallow to users.
Author: Johanderson Mogollon
Version: 0.0.1
Author URI: http://mogollon.com.ve
Tags: learnpress, lms, add-on, lessons permissions
Text Domain: learnpress-lessons-permissions
Domain Path: /languages/
*/

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

define( 'LP_ADDON_LESSONS_PERMISSIONS_FILE', __FILE__ );
define( 'LP_ADDON_LESSONS_PERMISSIONS_VER', '0.0.1' );
define( 'LP_ADDON_LESSONS_PERMISSIONS_REQUIRE_VER', '3.0.0' );

/**
 * Class LP_Addon_LESSONS_PERMISSIONS_Preload
 */
class LP_Addon_Lessons_Permissions_Preload {

	/**
	 * LP_Addon_Lessons_Permissions_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_LESSONS_PERMISSIONS', 'inc/load.php', __FILE__ );
		remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notice
	 */
	public function admin_notices() {
		?>
        <div class="error">
            <p><?php echo wp_kses(
					sprintf(
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-lessons-permissions' ),
						__( 'LearnPress Prerequisites Courses', 'learnpress-lessons-permissions' ),
						LP_ADDON_LESSONS_PERMISSIONS_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-lessons-permissions' ) ),
						LP_ADDON_LESSONS_PERMISSIONS_REQUIRE_VER
					),
					array(
						'a'      => array(
							'href'  => array(),
							'blank' => array()
						),
						'strong' => array()
					)
				); ?>
            </p>
        </div>
		<?php
	}
}

new LP_Addon_Lessons_Permissions_Preload();