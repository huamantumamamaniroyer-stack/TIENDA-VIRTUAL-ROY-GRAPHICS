<?php
/**
 * Automotive Car Dealer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Automotive Car Dealer
 */

if ( ! defined( 'AUTOMOTIVE_CAR_DEALER_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'AUTOMOTIVE_CAR_DEALER_VERSION', wp_get_theme()->get( 'Version' ) );
}

define( 'AUTOMOTIVE_CAR_DEALER_FREE_SUPPORT', 'https://www.revolutionwp.com/products/automotive-car-dealer' );
define( 'AUTOMOTIVE_CAR_DEALER_PRO_SUPPORT', 'https://wordpress.org/support/theme/automotive-car-dealer/' );
define( 'AUTOMOTIVE_CAR_DEALER_REVIEW', 'https://wordpress.org/support/theme/automotive-car-dealer/reviews/' );
define( 'AUTOMOTIVE_CAR_DEALER_BUY_NOW', 'https://www.revolutionwp.com/products/car-dealer-wordpress-theme' );
define( 'AUTOMOTIVE_CAR_DEALER_LIVE_DEMO', 'https://demo.revolutionwp.com/automotive-car-dealer-pro/' );
define( 'AUTOMOTIVE_CAR_DEALER_PRO_DOC', 'https://demo.revolutionwp.com/wpdocs/automotive-car-dealer-pro/' );
define( 'AUTOMOTIVE_CAR_DEALER_LITE_DOC', 'https://demo.revolutionwp.com/wpdocs/automotive-car-dealer-free/' );
define( 'AUTOMOTIVE_CAR_DEALER_BUNDLE', 'https://www.revolutionwp.com/products/wordpress-theme-bundle' );

if ( ! function_exists( 'automotive_car_dealer_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function automotive_car_dealer_setup() {

		load_theme_textdomain( 'automotive-car-dealer', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'woocommerce' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Experimental support for adding blocks inside nav menus
		add_theme_support( 'block-nav-menus' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );
	}
endif;
add_action( 'after_setup_theme', 'automotive_car_dealer_setup' );

function automotive_car_dealer_scripts() {

    wp_enqueue_style('automotive-car-dealer-style', get_stylesheet_uri(), array() );
    wp_enqueue_script('jquery-wow', get_template_directory_uri() . '/assets/js/wow.js', array('jquery'));
    wp_enqueue_style('animate-css', get_template_directory_uri() . '/assets/css/animate.css');
    
    wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri().'/assets/css/owl.carousel.css', array(), '2.2.1');
    wp_enqueue_script( 'owl.carousel-js', get_template_directory_uri(). '/assets/js/owl.carousel.js', array('jquery') , '2.3');
    
    //font-awesome
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/font-awesome/css/all.css', array(), '7.0.0' );
    
    wp_enqueue_script('automotive-car-dealer-custom-scripts', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '', true);
    wp_style_add_data( 'automotive-car-dealer-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'automotive_car_dealer_scripts' );


/**
 * Enqueue block editor styles
 */
function automotive_car_dealer_enqueue_block_editor_styles() {
    wp_enqueue_style(
        'automotive-car-dealer-block-editor-style', // Handle
        get_theme_file_uri( '/assets/css/block-editor.css' ), // File URI
        array(), // Dependencies
        filemtime( get_theme_file_path( '/assets/css/block-editor.css' ) ) // Version with file modification time for cache busting
    );
}
add_action( 'enqueue_block_editor_assets', 'automotive_car_dealer_enqueue_block_editor_styles' );


function automotive_car_dealer_init_setup() {

    // Customizer: Pro & documentation sections
    require get_template_directory() . '/inc/section-pro/customizer.php';

    // Add block patterns
    require get_template_directory() . '/inc/block-patterns.php';   
     
    // TGM
    require_once get_template_directory() . '/inc/tgm/tgm.php';

    // One-click plugin installation & demo import
    require_once get_template_directory() . '/inc/demo-import/demo-products.php';
    require_once get_template_directory() . '/inc/demo-import/class-automotive-car-dealer-demo-import.php';

}
add_action( 'after_setup_theme', 'automotive_car_dealer_init_setup' );


//////////////////////////////////////////////   Function for Translation Error   //////////////////////////////////////////////////////
function automotive_car_dealer_enqueue_function() {

    /**
    * GET START.
    */
    require get_template_directory() . '/getstarted/automotive_car_dealer_about_page.php';

    
}
add_action( 'after_setup_theme', 'automotive_car_dealer_enqueue_function' );

// Add admin notice
function automotive_car_dealer_admin_notice() {
    if ( get_option( 'automotive_car_dealer_admin_notice' ) ) {
        return;
    }

    if ( is_network_admin() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $automotive_car_dealer_current_screen = get_current_screen();

    if ( $automotive_car_dealer_current_screen && 'appearance_page_automotive-car-dealer-getstart-page' === $automotive_car_dealer_current_screen->base ) {
        return;
    }
    ?>
    <div class="notice notice-success wprev-welcome-notice">
        <p class="wprev-dismiss-link">
            <strong>
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'automotive_car_dealer_admin_notice', '1' ), 'automotive_car_dealer_dismiss_notice' ) ); ?>">
                    <?php esc_html_e( 'Dismiss', 'automotive-car-dealer' ); ?>
                </a>
            </strong>
        </p>

        <div class="wprev-welcome-notice-wrap">
            <h2 class="wprev-notice-title">
                <span class="dashicons dashicons-admin-home"></span>
                <?php
                    $automotive_car_dealer_theme_name = wp_get_theme()->get( 'Name' );
                    /* translators: %s!: Theme Name. */
                    echo esc_html( sprintf( __( 'Welcome to the free theme: %s!', 'automotive-car-dealer' ), $automotive_car_dealer_theme_name ) );
                ?>
            </h2>
            <p class="wprev-notice-desc">
                <?php esc_html_e( 'Get started by exploring the features of your new theme. Customize your design, add your content, and create a site that fits your vision.', 'automotive-car-dealer' ); ?>
            </p>

            <div class="wprev-welcome-info">
                <div class="wprev-welcome-thumb">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr_e( 'Theme Screenshot', 'automotive-car-dealer' ); ?>">
                </div>

                <?php if ( Automotive_Car_Dealer_Demo_Import::current_user_can_run() ) : ?>
                <div class="wprev-welcome-import">
                    <?php if ( Automotive_Car_Dealer_Demo_Import::is_complete() ) : ?>
                        <h3><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Your Demo Is Ready', 'automotive-car-dealer' ); ?></h3>
                        <p><?php esc_html_e( 'The recommended plugins are active and the demo products have been imported. Visit your site to see it in action.', 'automotive-car-dealer' ); ?></p>
                    <?php else : ?>
                        <h3><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Quick Start: Import Demo', 'automotive-car-dealer' ); ?></h3>
                        <p><?php esc_html_e( 'Install the recommended plugins and import the demo products in one click. Get a complete site in minutes.', 'automotive-car-dealer' ); ?></p>
                    <?php endif; ?>
                    <?php Automotive_Car_Dealer_Demo_Import::render_button( 'notice' ); ?>
                </div>
                <?php endif; ?>

                <div class="wprev-welcome-getting-started">
                    <h3><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Customize Your Theme', 'automotive-car-dealer' ); ?></h3>
                    <p><?php esc_html_e( 'Want to make it truly yours? Explore the Getting Started Guide to personalize your site to suit your needs.', 'automotive-car-dealer' ); ?></p>
                    <p><a class="info-link button" href="<?php echo esc_url( admin_url( 'themes.php?page=automotive-car-dealer-getstart-page' ) ); ?>"><?php esc_html_e( 'View Getting Started Guide', 'automotive-car-dealer' ); ?></a></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'admin_notices', 'automotive_car_dealer_admin_notice' );

if ( ! function_exists( 'automotive_car_dealer_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function automotive_car_dealer_update_admin_notice() {
    if ( isset( $_GET['automotive_car_dealer_admin_notice'] ) && '1' === $_GET['automotive_car_dealer_admin_notice'] && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'automotive_car_dealer_dismiss_notice' );
        update_option( 'automotive_car_dealer_admin_notice', true );
        wp_safe_redirect( remove_query_arg( array( 'automotive_car_dealer_admin_notice', '_wpnonce' ) ) );
        exit;
    }
}
endif;
add_action( 'admin_init', 'automotive_car_dealer_update_admin_notice' );

add_action( 'after_switch_theme', 'automotive_car_dealer_setup_options' );
function automotive_car_dealer_setup_options() {
    update_option( 'automotive_car_dealer_admin_notice', false );
}

// Enqueue custom admin notice CSS
function automotive_car_dealer_enqueue_admin_notice_css( $hook ) {
    // Load CSS only on wp-admin pages (not the front end)
    wp_enqueue_style(
        'automotive-car-dealer-admin-notice-style',
        get_template_directory_uri() . '/assets/css/admin-notice.css',
        array(),
        AUTOMOTIVE_CAR_DEALER_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'automotive_car_dealer_enqueue_admin_notice_css' );


// changelog
function automotive_car_dealer_get_changelog_from_readme() {
    $file_path = get_template_directory() . '/readme.txt';

    if (!file_exists($file_path)) {
        return [];
    }

    $content = file_get_contents($file_path);

    // Check if changelog exists
    if (strpos($content, '== Changelog ==') === false) {
        return [];
    }

    // Extract only changelog section
    $changelog = explode('== Changelog ==', $content)[1];

    // Match versions like = 1.0 =
    preg_match_all('/=\s*([\d\.]+)\s*=\s*(.*?)(?=\n=\s*[\d\.]+\s*=|\Z)/s', $changelog, $matches, PREG_SET_ORDER);

    return $matches;
}