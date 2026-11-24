<?php
/**
 * Demo WooCommerce products for the homepage "Power in Every Part" section.
 *
 * Each product is identified by its unique `key`, which is stored as post meta so the
 * import can be run again without creating duplicates. Images are file names inside
 * the theme's `assets/images/` directory (child themes can override them).
 *
 * @package Automotive Car Dealer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the demo products.
 *
 * @return array[]
 */
function automotive_car_dealer_get_demo_products() {
	$automotive_car_dealer_products = array(
		array(
			'key'               => 'car-parts-mufflers-and-pipes',
			'name'              => __( 'Car Parts Mufflers And Pipes', 'automotive-car-dealer' ),
			'regular_price'     => '18.00',
			'description'       => __( 'Designed for Lex H-21 Vehicles. A durable stainless steel muffler and pipe set that reduces engine noise and improves exhaust flow.', 'automotive-car-dealer' ),
			'short_description' => __( 'Available Finance Plans via Partner Institutions', 'automotive-car-dealer' ),
			'image'             => 'product-img1.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Car Parts', 'automotive-car-dealer' ), __( 'Exhaust', 'automotive-car-dealer' ) ),
		),
		array(
			'key'               => 'syntetic-oil-5w-40',
			'name'              => __( 'Syntetic Oil 5W-40', 'automotive-car-dealer' ),
			'regular_price'     => '18.00',
			'description'       => __( 'Designed for Lex H-21 Vehicles. A fully synthetic engine oil that protects against wear and keeps the engine clean in every season.', 'automotive-car-dealer' ),
			'short_description' => __( 'Available Finance Plans via Partner Institutions', 'automotive-car-dealer' ),
			'image'             => 'product-img2.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Car Parts', 'automotive-car-dealer' ), __( 'Engine Oil', 'automotive-car-dealer' ) ),
		),
		array(
			'key'               => 'high-performance-tires',
			'name'              => __( 'High-Performance Tires', 'automotive-car-dealer' ),
			'regular_price'     => '18.00',
			'description'       => __( 'Designed for Lex H-21 Vehicles. Grippy, long-lasting tires built for confident handling on wet and dry roads.', 'automotive-car-dealer' ),
			'short_description' => __( 'Available Finance Plans via Partner Institutions', 'automotive-car-dealer' ),
			'image'             => 'product-img3.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Car Parts', 'automotive-car-dealer' ), __( 'Tires', 'automotive-car-dealer' ) ),
		),
		array(
			'key'               => 'ninja-rims-r20-1-strada-nera',
			'name'              => __( 'Ninja Rims R20 1 Strada Nera', 'automotive-car-dealer' ),
			'regular_price'     => '18.00',
			'description'       => __( 'Designed for Lex H-21 Vehicles. Lightweight 20-inch alloy rims with a black finish for a bold, sporty look.', 'automotive-car-dealer' ),
			'short_description' => __( 'Available Finance Plans via Partner Institutions', 'automotive-car-dealer' ),
			'image'             => 'product-img4.png',
			'gallery'           => array(),
			'categories'        => array( __( 'Car Parts', 'automotive-car-dealer' ), __( 'Rims', 'automotive-car-dealer' ) ),
		),
	);

	/**
	 * Filters the demo products imported by the one-click setup.
	 *
	 * @param array[] $automotive_car_dealer_products Demo product definitions.
	 */
	return apply_filters( 'automotive_car_dealer_demo_products', $automotive_car_dealer_products );
}
