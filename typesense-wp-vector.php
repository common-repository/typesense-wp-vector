<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://knowhalim.com
 * @since             1.0.0
 * @package           Typesense_Wp_Vector
 *
 * @wordpress-plugin
 * Plugin Name:       Typesense WP Vector
 * Plugin URI:        https://knowhalim.com/app
 * Description:       Typesense using vector search with OpenAI API
 * Version:           1.0.0
 * Author:            Knowhalim
 * Author URI:        https://knowhalim.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       typesense-wp-vector
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TYPESENSE_WP_VECTOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-typesense-wp-vector-activator.php
 */
function tswp_activate_typesensevector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-typesense-wp-vector-activator.php';
	Typesense_Wp_Vector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-typesense-wp-vector-deactivator.php
 */
function tswp_deactivate_typesensevector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-typesense-wp-vector-deactivator.php';
	Typesense_Wp_Vector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'tswp_activate_typesensevector' );
register_deactivation_hook( __FILE__, 'tswp_deactivate_typesensevector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-typesense-wp-vector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function tswp_run_thisplugin() {

	$plugin = new Typesense_Wp_Vector();
	$plugin->run();

}
tswp_run_thisplugin();
