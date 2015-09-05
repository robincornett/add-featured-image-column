<?php
/**
 * Simple plugin to add the post thumbnail to the WordPress Admin
 *
 * @package   AddFeaturedImageColumn
 * @author    Robin Cornett <hello@robincornett.com>
 * @license   GPL-2.0+
 * @link      http://robincornett.com
 * @copyright 2015 Robin Cornett Creative, LLC
 *
 * @wordpress-plugin
 * Plugin Name:       Add Featured Image Column
 * Plugin URI:        http://github.com/robincornett/add-featured-image-column/
 * Description:       This plugin adds a featured image column to the WordPress admin.
 * Version:           0.9.0
 * Author:            Robin Cornett
 * Author URI:        http://robincornett.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action( 'admin_init', 'afic_add_post_type_column' );
function afic_add_post_type_column() {
	if ( class_exists( 'Display_Featured_Image_Genesis' ) ) {
		return;
	}
	$args       = array(
		'public'   => true,
		'_builtin' => false,
	);
	$output     = 'names';
	$post_types = get_post_types( $args, $output );
	$post_types['post'] = 'post';
	$post_types['page'] = 'page';
	foreach ( $post_types as $post_type ) {
		if ( ! post_type_supports( $post_type, 'thumbnail' ) ) {
			continue;
		}
		add_filter( "manage_edit-{$post_type}_columns", 'afic_add_featured_image_column' );
		add_action( "manage_{$post_type}_posts_custom_column", 'afic_manage_image_column', 10, 2 );
		add_action( 'admin_enqueue_scripts', 'afic_featured_image_column_width' );
	}
}

/**
 * add featured image column
 * @param column $columns set up new column to show featured image for taxonomies/posts/etc.
 *
 * @since 0.9.0
 */
function afic_add_featured_image_column( $columns ) {

	$new_columns = $columns;
	array_splice( $new_columns, 1 );

	$new_columns['featured_image'] = __( 'Featured Image', 'add-featured-image-column' );

	return array_merge( $new_columns, $columns );

}

/**
 * manage new post_type column
 * @param  column id $column  column id is featured_image
 * @param  post id $post_id id of each post
 * @return featured image          display featured image, if it exists, for each post
 *
 * @since 0.9.0
 */
function afic_manage_image_column( $column, $post_id ) {

	if ( 'featured_image' !== $column ) {
		return;
	}
	$image_id = get_post_thumbnail_id( $post_id );
	if ( ! $image_id ) {
		return;
	}

	$args = array(
		'image_id' => $image_id,
		'context'  => 'post',
		'alt'      => the_title_attribute( 'echo=0' ),
	);

	echo wp_kses_post( afic_admin_column_image( $args ) );

}

/**
 * Generic function to return featured image
 * @param  array $args array of values to pass to function ( image_id, context, alt_tag )
 * @return string       image html
 *
 * @since 0.9.0
 */
function afic_admin_column_image( $args ) {
	$image_id = $args['image_id'];
	$preview  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
	if ( ! $preview ) {
		return;
	}
	return sprintf( '<img src="%1$s" alt="%2$s" />', $preview[0], $args['alt'] );
}

/**
 * sets a width for the featured image column
 * @return stylesheet inline stylesheet to set featured image column width
 */
function afic_featured_image_column_width() {
	$screen = get_current_screen();
	if ( in_array( $screen->base, array( 'edit' ) ) ) { ?>
		<style type="text/css">
			.column-featured_image { width: 105px; }
			.column-featured_image img { margin: 0 auto; display: block; height: auto; width: auto; max-width: 60px; max-height: 80px; }
			@media screen and (max-width: 782px) { .column-featured_image img { margin: 0; } }
		</style> <?php
	}
}
