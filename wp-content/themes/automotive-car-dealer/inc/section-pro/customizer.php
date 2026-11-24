<?php 
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class automotive_car_dealer_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Automotive_Car_Dealer_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Automotive_Car_Dealer_Customize_Section_Pro( $manager,'automotive_car_dealer_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Automotive Car Dealer Pro', 'automotive-car-dealer' ),
			'pro_text' => esc_html__( 'Upgrade Pro', 'automotive-car-dealer' ),
			'pro_url'  => esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ),
		) )	);

		// Register sections.
		$manager->add_section( new Automotive_Car_Dealer_Customize_Section_Pro( $manager,'automotive_car_dealer_doc', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Lite Documentation', 'automotive-car-dealer' ),
			'pro_text' => esc_html__( 'Instruction', 'automotive-car-dealer' ),
			'pro_url'  => esc_url( AUTOMOTIVE_CAR_DEALER_LITE_DOC ),
		) )	);

		// Register sections.
		$manager->add_section( new Automotive_Car_Dealer_Customize_Section_Pro( $manager, 'automotive_car_dealer_live_demo', array(
			'priority'   => 1,
			'title'      => esc_html__( 'Pro Theme Demo', 'automotive-car-dealer' ),
			'pro_text'   => esc_html__( 'Live Preview', 'automotive-car-dealer' ),
			'pro_url'    => esc_url( AUTOMOTIVE_CAR_DEALER_LIVE_DEMO ),
		) ) );

		// Register sections.
		$manager->add_section( new Automotive_Car_Dealer_Customize_Section_Pro( $manager, 'automotive_car_dealer_bundle', array(
			'priority'   => 1,
			'title'      => esc_html__( 'Theme Bundle', 'automotive-car-dealer' ),
			'pro_text'   => esc_html__( 'Get Bundle', 'automotive-car-dealer' ),
			'pro_url'    => esc_url( AUTOMOTIVE_CAR_DEALER_BUNDLE ),
		) ) );
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_style( 'automotive-car-dealer-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customizer.css' );
	}
}

// Doing this customizer thang!
automotive_car_dealer_Customize::get_instance();