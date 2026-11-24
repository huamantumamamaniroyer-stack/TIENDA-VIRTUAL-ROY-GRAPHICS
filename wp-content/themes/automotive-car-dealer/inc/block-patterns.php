<?php
/**
 * Automotive Car Dealer: Block Patterns
 *
 * @since Automotive Car Dealer 1.0
 */

 /**
  * Get patterns content.
  *
  * @param string $file_name Filename.
  * @return string
  */
function automotive_car_dealer_get_pattern_content( $file_name ) {
	ob_start();
	include get_theme_file_path( '/patterns/' . $file_name . '.php' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers block patterns and categories.
 *
 * @since Automotive Car Dealer 1.0
 *
 * @return void
 */
function automotive_car_dealer_register_block_patterns() {

	$patterns = array(
		'header-default' => array(
			'title'      => __( 'Default header', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-headers' ),
			'blockTypes' => array( 'parts/header' ),
		),
		'footer-default' => array(
			'title'      => __( 'Default footer', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-footers' ),
			'blockTypes' => array( 'parts/footer' ),
		),
		'home-banner' => array(
			'title'      => __( 'Home Banner', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-banner' ),
		),
		'product-section' => array(
			'title'      => __( 'Product Section', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-product-section' ),
		),
		'latest-blog-section' => array(
			'title'      => __( 'Latest Blog Section', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-latest-blog-section' ),
		),
		'primary-sidebar' => array(
			'title'    => __( 'Primary Sidebar', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-sidebars' ),
		),
		'hidden-404' => array(
			'title'    => __( '404 content', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-pages' ),
		),
		'post-listing-single-column' => array(
			'title'    => __( 'Post Single Column', 'automotive-car-dealer' ),
			//'inserter' => false,
			'categories' => array( 'automotive-car-dealer-query' ),
		),
		'post-listing-two-column' => array(
			'title'    => __( 'Post Two Column', 'automotive-car-dealer' ),
			//'inserter' => false,
			'categories' => array( 'automotive-car-dealer-query' ),
		),
		'post-listing-three-column' => array(
			'title'    => __( 'Post Three Column', 'automotive-car-dealer' ),
			//'inserter' => false,
			'categories' => array( 'automotive-car-dealer-query' ),
		),
		'post-listing-four-column' => array(
			'title'    => __( 'Post Four Column', 'automotive-car-dealer' ),
			//'inserter' => false,
			'categories' => array( 'automotive-car-dealer-query' ),
		),
		'feature-post-column' => array(
			'title'    => __( 'Feature Post Column', 'automotive-car-dealer' ),
			//'inserter' => false,
			'categories' => array( 'automotive-car-dealer-query' ),
		),
		'comment-section-1' => array(
			'title'    => __( 'Comment Section 1', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-comment-sections' ),
		),
		'cover-with-post-title' => array(
			'title'    => __( 'Cover With Post Title', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-banner-sections' ),
		),
		'theme-button' => array(
			'title'    => __( 'Theme Button', 'automotive-car-dealer' ),
			'categories' => array( 'automotive-car-dealer-theme-button' ),
		),
	);

	$block_pattern_categories = array(
		'automotive-car-dealer-footers' => array( 'label' => __( 'Footers', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-headers' => array( 'label' => __( 'Headers', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-pages'   => array( 'label' => __( 'Pages', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-query'   => array( 'label' => __( 'Query', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-sidebars'   => array( 'label' => __( 'Sidebars', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-banner'   => array( 'label' => __( 'Banner Sections', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-product-section'   => array( 'label' => __( 'Product Section', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-latest-blog-section'   => array( 'label' => __( 'Latest Blog Section', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-comment-section'   => array( 'label' => __( 'Comment Sections', 'automotive-car-dealer' ) ),
		'automotive-car-dealer-theme-button'   => array( 'label' => __( 'Theme Button Sections', 'automotive-car-dealer' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since Automotive Car Dealer 1.0
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'automotive_car_dealer_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since Automotive Car Dealer 1.0
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$patterns = apply_filters( 'automotive_car_dealer_block_patterns', $patterns );

	foreach ( $patterns as $block_pattern => $pattern ) {
		$pattern['content'] = automotive_car_dealer_get_pattern_content( $block_pattern );
		register_block_pattern(
			'automotive-car-dealer/' . $block_pattern,
			$pattern
		);
	}
}
add_action( 'init', 'automotive_car_dealer_register_block_patterns', 9 );
