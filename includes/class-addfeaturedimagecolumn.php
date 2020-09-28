<?php

/**
 * Main plugin class
 *
 * @package   AddFeaturedImageColumn
 * @author    Robin Cornett <hello@robincornett.com>
 * @license   GPL-2.0+
 * @link      http://robincornett.com
 * @copyright 2015 Robin Cornett Creative, LLC
 */

class AddFeaturedImageColumn {

	public function run() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_init', array( $this, 'add_post_type_column' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'featured_image_column_width' ) );
	}

	/**
	 * Set up text domain for translations
	 *
	 * @since 1.1.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'add-featured-image-column', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function add_post_type_column() {
		if ( class_exists( 'Display_Featured_Image_Genesis' ) ) {
			deactivate_plugins( ADDFEATUREDIMAGECOLUMN_BASENAME );
			add_action( 'admin_notices', array( $this, 'error_message' ) );
		}
		$args       = array(
			'_builtin' => false,
			'show_ui'  => true,
		);
		$output     = 'names';
		$post_types = get_post_types( $args, $output );
		$post_types['post'] = 'post';
		$post_types['page'] = 'page';
		if ( class_exists( 'WooCommerce' ) ) {
			unset( $post_types['product'] );
		}
		$post_types = apply_filters( 'addfeaturedimagecolumn_post_types', $post_types, $args );
		foreach ( $post_types as $post_type ) {
			if ( ! post_type_supports( $post_type, 'thumbnail' ) ) {
				continue;
			}
			add_filter( "manage_edit-{$post_type}_columns", array( $this, 'add_featured_image_column' ) );
			add_action( "manage_{$post_type}_posts_custom_column", array( $this, 'manage_image_column' ), 10, 2 );
			add_filter( "manage_edit-{$post_type}_sortable_columns", array( $this, 'make_sortable' ) );
			add_action( 'pre_get_posts', array( $this, 'orderby' ) );
		}
	}

	/**
	 * Error message if we're already using Display Featured Image for Genesis.
	 *
	 * @since 1.1.0
	 */
	public function error_message() {
		$error = sprintf( __( 'You are using Display Featured Image for Genesis and do not need to use Add Featured Image Column, so it has been deactivated.', 'add-featured-image-column' ) );
		echo '<div class="error"><p>' . esc_attr( $error ) . '</p></div>';

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	/**
	 * add featured image column
	 * @param array $columns set up new column to show featured image for taxonomies/posts/etc.
	 *
	 * @return array
	 * @since 0.9.0
	 */
	public function add_featured_image_column( $columns ) {

		$new_columns = $columns;
		array_splice( $new_columns, 1 );

		$new_columns['featured_image'] = __( 'Image', 'add-featured-image-column' );

		return array_merge( $new_columns, $columns );

	}

	/**
	 * Make the featured image column sortable.
	 * @param $columns
	 * @return mixed
	 * @since 1.1.0
	 */
	public function make_sortable( $columns ) {
		$columns['featured_image'] = 'featured_image';
		return $columns;
	}

	/**
	 * Set a custom query to handle sorting by featured image
	 * @param $query WP_Query
	 * @since 1.1.0
	 */
	public function orderby( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby' );
		if ( 'featured_image' === $orderby ) {
			$query->set(
				'meta_query', array(
					'relation' => 'OR',
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				)
			);
			$post_type       = $query->get( 'post_type' );
			$secondary_order = is_post_type_hierarchical( $post_type ) ? 'title' : 'date';
			$query->set( 'orderby', "meta_value_num $secondary_order" );
		}
	}

	/**
	 * manage new post_type column
	 * @param  $column string $column  column id is featured_image
	 * @param  $post_id int id of each post
	 *
	 * @since 0.9.0
	 */
	public function manage_image_column( $column, $post_id ) {

		if ( 'featured_image' !== $column ) {
			return;
		}
		$image_id = get_post_thumbnail_id( $post_id );
		if ( ! $image_id ) {
			echo '<span aria-hidden="true">—</span>';
			printf( '<span class="screen-reader-text">%s</span>', esc_html__( 'No image', 'add-featured-image-column' ) );
			return;
		}

		$args = array(
			'image_id' => $image_id,
			'context'  => 'post',
			'alt'      => the_title_attribute( 'echo=0' ),
		);

		echo wp_kses_post( $this->admin_column_image( $args ) );
	}

	/**
	 * Generic function to return featured image
	 * @param $args array of values to pass to function ( image_id, context, alt_tag )
	 *
	 * @return string
	 * @since 0.9.0
	 */
	protected function admin_column_image( $args ) {
		$image_id = $args['image_id'];
		$preview  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		$preview  = apply_filters( 'addfeaturedimagecolumn_thumbnail', $preview, $image_id );
		if ( ! $preview ) {
			return '';
		}
		return sprintf( '<img src="%1$s" alt="%2$s" />', $preview[0], $args['alt'] );
	}

	/**
	 * Creates an inline stylesheet to set featured image column width
	 */
	public function featured_image_column_width() {
		$screen = get_current_screen();
		if ( ! post_type_supports( $screen->post_type, 'thumbnail' ) ) {
			return;
		}
		if ( in_array( $screen->base, array( 'edit' ), true ) ) { ?>
			<style type="text/css">
				.column-featured_image { width: 105px; }
				.column-featured_image img { margin: 0 auto; height: auto; width: auto; max-width: 60px; max-height: 80px; }
				@media screen and (max-width: 782px) { .column-featured_image, .wp-list-table .is-expanded td.column-featured_image:not(.hidden) { display: table-cell !important; width: 52px; } .column-featured_image.hidden { display: none !important; } .column-featured_image img { margin: 0; max-width: 42px; } }
			</style> <?php
		}
	}
}
