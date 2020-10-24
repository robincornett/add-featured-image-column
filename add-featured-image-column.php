<?php
/**
 * Simple plugin to add the post thumbnail to the WordPress Admin
 *
 * @package   AddFeaturedImageColumn
 * @author    Robin Cornett <hello@robincornett.com>
 * @license   GPL-2.0+
 * @link      https://robincornett.com
 * @copyright 2015-2020 Robin Cornett Creative, LLC
 *
 * @wordpress-plugin
 * Plugin Name:       Add Featured Image Column
 * Plugin URI:        https://github.com/robincornett/add-featured-image-column/
 * Description:       This plugin adds a featured image column to the WordPress admin.
 * Version:           1.1.6
 * Author:            Robin Cornett
 * Author URI:        https://robincornett.com
 * Text Domain:       add-featured-image-column
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ADDFEATUREDIMAGECOLUMN_BASENAME' ) ) {
	define( 'ADDFEATUREDIMAGECOLUMN_BASENAME', plugin_basename( __FILE__ ) );
}

// Include classes
function addfeaturedimagecolumn_require() {
	$files = array(
		'class-addfeaturedimagecolumn',
	);

	foreach ( $files as $file ) {
		require plugin_dir_path( __FILE__ ) . 'includes/' . $file . '.php';
	}
}
addfeaturedimagecolumn_require();

// Instantiate main class
$addfeaturedimagecolumn = new AddFeaturedImageColumn();

// Run the plugin
$addfeaturedimagecolumn->run();
