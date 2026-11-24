<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'automotive_car_dealer_Welcome' ) ) {

	class automotive_car_dealer_Welcome {
		public $theme_fields;

		public function __construct( $automotive_car_dealer_fields = array() ) {
			$this->theme_fields = $automotive_car_dealer_fields;
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_menu', array( $this, 'automotive_car_dealer_getstart_page_menu' ) );
			add_action( 'in_admin_header', array( $this, 'hide_admin_notices' ), 99 );
		}

		// Remove all admin notices on the Getting Started page.
		public function hide_admin_notices() {
			$automotive_car_dealer_screen = get_current_screen();
			if ( ! $automotive_car_dealer_screen || 'appearance_page_automotive-car-dealer-getstart-page' !== $automotive_car_dealer_screen->id ) {
				return;
			}

			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
			remove_all_actions( 'network_admin_notices' );
			remove_all_actions( 'user_admin_notices' );
		}

		public function admin_scripts( $automotive_car_dealer_hook ) {
			if ( 'appearance_page_automotive-car-dealer-getstart-page' !== $automotive_car_dealer_hook ) {
				return;
			}

			wp_enqueue_style(
				'automotive-car-dealer-getstart-page-style',
				get_template_directory_uri() . '/getstarted/assets/css/getstart-page.css',
				array( 'dashicons' ),
				filemtime( get_template_directory() . '/getstarted/assets/css/getstart-page.css' )
			);

			wp_enqueue_script(
				'automotive-car-dealer-getstart-page-script',
				get_template_directory_uri() . '/getstarted/assets/js/getstart-page.js',
				array(),
				filemtime( get_template_directory() . '/getstarted/assets/js/getstart-page.js' ),
				true
			);

			wp_localize_script(
				'automotive-car-dealer-getstart-page-script',
				'wprGetstart',
				array(
					'copied' => esc_html__( 'Copied!', 'automotive-car-dealer' ),
					'copy'   => esc_html__( 'Copy Code', 'automotive-car-dealer' ),
				)
			);
		}

        public function theme_info($automotive_car_dealer_id, $automotive_car_dealer_screenshot = false) {
            $automotive_car_dealer_themedata = wp_get_theme();
            return ($automotive_car_dealer_screenshot === true) ? esc_url($automotive_car_dealer_themedata->get_screenshot()) : esc_html($automotive_car_dealer_themedata->get($automotive_car_dealer_id));
        }

        public function automotive_car_dealer_getstart_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'automotive-car-dealer'), $this->theme_info('Name')),
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'automotive-car-dealer'), $this->theme_info('Name')),
                'edit_theme_options',
                'automotive-car-dealer-getstart-page',
                array( $this, 'automotive_car_dealer_getstart_page' )
            );
		}

        public function automotive_car_dealer_getstart_page() {
            $automotive_car_dealer_section     = isset( $_GET['section'] ) ? sanitize_key( wp_unslash( $_GET['section'] ) ) : 'automotive_car_dealer_getting_started';
            $automotive_car_dealer_text_domain = $this->theme_info( 'TextDomain' );
            $automotive_car_dealer_page_url    = admin_url( 'themes.php?page=automotive-car-dealer-getstart-page' );

            $automotive_car_dealer_tabs = array(
                'automotive_car_dealer_getting_started' => array(
                    'label' => esc_html__( 'Getting Started', 'automotive-car-dealer' ),
                    'url'   => $automotive_car_dealer_page_url,
                ),
                'automotive_car_dealer_free_pro' => array(
                    'label' => esc_html__( 'Free VS Pro', 'automotive-car-dealer' ),
                    'url'   => add_query_arg( 'section', 'automotive_car_dealer_free_pro', $automotive_car_dealer_page_url ),
                ),
                'bundle' => array(
                    'label' => esc_html__( 'Theme Bundle', 'automotive-car-dealer' ),
                    'url'   => add_query_arg( 'section', 'bundle', $automotive_car_dealer_page_url ),
                ),
                'changelog' => array(
                    'label' => esc_html__( 'Changelog', 'automotive-car-dealer' ),
                    'url'   => add_query_arg( 'section', 'changelog', $automotive_car_dealer_page_url ),
                ),
                'support' => array(
                    'label' => esc_html__( 'Support', 'automotive-car-dealer' ),
                    'url'   => add_query_arg( 'section', 'support', $automotive_car_dealer_page_url ),
                ),
                'review' => array(
                    'label'    => esc_html__( 'Rate & Review', 'automotive-car-dealer' ),
                    'url'      => 'https://wordpress.org/support/theme/' . $automotive_car_dealer_text_domain . '/reviews/#new-post',
                    'external' => true,
                ),
            );

            $automotive_car_dealer_panels = array(
                'automotive_car_dealer_getting_started' => 'automotive_car_dealer_getting_started',
                'automotive_car_dealer_free_pro'        => 'automotive_car_dealer_free_pro',
                'bundle'                                  => 'automotive_car_dealer_bundle',
                'changelog'                               => 'changelog',
                'support'                                 => 'automotive_car_dealer_support',
            );

            if ( ! isset( $automotive_car_dealer_panels[ $automotive_car_dealer_section ] ) ) {
                $automotive_car_dealer_section = 'automotive_car_dealer_getting_started';
            }

            $automotive_car_dealer_bundle_features = array(
                esc_html__( '60+ Premium Themes', 'automotive-car-dealer' ),
                esc_html__( 'Regular Updates & Support', 'automotive-car-dealer' ),
                esc_html__( 'Use on Unlimited Websites', 'automotive-car-dealer' ),
                esc_html__( 'All Future Themes Included', 'automotive-car-dealer' ),
            );
            ?>
            <div class="wrap wprev-getstart">

                <section class="wprev-hero">
                    <div class="wprev-hero__content">
                        <p class="wprev-eyebrow"><?php esc_html_e( 'Welcome to', 'automotive-car-dealer' ); ?></p>
                        <h1 class="wprev-hero__title">
                            <?php echo esc_html( $this->theme_info( 'Name' ) ); ?>
                            <span class="wprev-badge"><?php esc_html_e( 'Free Version', 'automotive-car-dealer' ); ?></span>
                        </h1>
                        <p class="wprev-hero__version">
                            <?php
                            /* translators: %s: Theme version. */
                            printf( esc_html__( 'Version %s', 'automotive-car-dealer' ), esc_html( $this->theme_info( 'Version' ) ) );
                            ?>
                        </p>
                    </div>
                    <div class="wprev-hero__media">
                        <nav class="wprev-hero__actions" aria-label="<?php esc_attr_e( 'Quick links', 'automotive-car-dealer' ); ?>">
                            <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ); ?>">
                                <span class="dashicons dashicons-cart" aria-hidden="true"></span>
                                <?php esc_html_e( 'Buy Now', 'automotive-car-dealer' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_LIVE_DEMO ); ?>">
                                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                                <?php esc_html_e( 'Live Demo', 'automotive-car-dealer' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_LITE_DOC ); ?>">
                                <span class="dashicons dashicons-media-document" aria-hidden="true"></span>
                                <?php esc_html_e( 'Documentation', 'automotive-car-dealer' ); ?>
                            </a>
                            <a class="wprev-btn wprev-btn--outline-pink" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUNDLE ); ?>">
                                <span class="dashicons dashicons-screenoptions" aria-hidden="true"></span>
                                <?php esc_html_e( 'Get Bundle', 'automotive-car-dealer' ); ?>
                            </a>
                        </nav>
                    </div>
                </section>

                <section class="wprev-bundle">
                    <div class="wprev-bundle__media" aria-hidden="true">
                        <img class="wprev-bundle__shot wprev-bundle__shot--1" src="<?php echo esc_url( get_template_directory_uri() . '/getstarted/assets/images/getstart-bundle.png' ); ?>" alt="" />
                        <span class="wprev-bundle__seal">
                            <strong><?php esc_html_e( '60+', 'automotive-car-dealer' ); ?></strong>
                            <?php esc_html_e( 'Premium Themes', 'automotive-car-dealer' ); ?>
                        </span>
                    </div>
                    <div class="wprev-bundle__content">
                        <p class="wprev-eyebrow wprev-eyebrow--offer">
                            <span class="dashicons dashicons-awards" aria-hidden="true"></span>
                            <?php esc_html_e( 'Limited Time Offer', 'automotive-car-dealer' ); ?>
                        </p>
                        <h2 class="wprev-bundle__title">
                            <?php esc_html_e( 'Get the Complete', 'automotive-car-dealer' ); ?>
                            <span><?php esc_html_e( 'Theme Bundle', 'automotive-car-dealer' ); ?></span>
                        </h2>
                        <p class="wprev-bundle__desc"><?php esc_html_e( 'Unlock 60+ premium WordPress themes, including eCommerce, Business, Blog, Portfolio and more. Build unlimited websites with one bundle.', 'automotive-car-dealer' ); ?></p>
                        <ul class="wprev-checklist wprev-checklist--grid">
                            <?php foreach ( $automotive_car_dealer_bundle_features as $automotive_car_dealer_feature ) : ?>
                                <li><?php echo esc_html( $automotive_car_dealer_feature ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="wprev-bundle__price">
                        <span class="wprev-ribbon"><?php esc_html_e( 'Best Value', 'automotive-car-dealer' ); ?></span>
                        <del><?php esc_html_e( '$2340', 'automotive-car-dealer' ); ?></del>
                        <strong><?php esc_html_e( '$79', 'automotive-car-dealer' ); ?></strong>
                        <?php $this->coupon( 'BUNDLE10', sprintf( /* translators: %d: Discount percentage. */ esc_html__( 'Flat %d%% OFF on Bundle', 'automotive-car-dealer' ), 10 ) ); ?>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUNDLE ); ?>">
                            <?php esc_html_e( 'Get the Bundle', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                    </div>
                </section>

                <nav class="wprev-tabs" aria-label="<?php esc_attr_e( 'Getting started sections', 'automotive-car-dealer' ); ?>">
                    <?php foreach ( $automotive_car_dealer_tabs as $automotive_car_dealer_id => $automotive_car_dealer_tab ) : ?>
                        <a
                            class="wprev-tabs__item<?php echo ( $automotive_car_dealer_id === $automotive_car_dealer_section ) ? ' is-active' : ''; ?>"
                            href="<?php echo esc_url( $automotive_car_dealer_tab['url'] ); ?>"
                            <?php if ( ! empty( $automotive_car_dealer_tab['external'] ) ) : ?>
                                target="_blank" rel="noopener"
                            <?php else : ?>
                                data-wprev-tab="<?php echo esc_attr( $automotive_car_dealer_id ); ?>"
                            <?php endif; ?>
                            <?php if ( $automotive_car_dealer_id === $automotive_car_dealer_section ) : ?>aria-current="page"<?php endif; ?>
                        >
                            <?php echo esc_html( $automotive_car_dealer_tab['label'] ); ?>
                            <?php if ( ! empty( $automotive_car_dealer_tab['external'] ) ) : ?>
                                <span class="dashicons dashicons-external" aria-hidden="true"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <?php foreach ( $automotive_car_dealer_panels as $automotive_car_dealer_id => $automotive_car_dealer_callback ) : ?>
                    <div class="wprev-panel" id="wprev-panel-<?php echo esc_attr( $automotive_car_dealer_id ); ?>" data-wprev-panel="<?php echo esc_attr( $automotive_car_dealer_id ); ?>"<?php echo ( $automotive_car_dealer_id === $automotive_car_dealer_section ) ? '' : ' hidden'; ?>>
                        <?php $this->$automotive_car_dealer_callback(); ?>
                    </div>
                <?php endforeach; ?>

            </div>
            <?php
		}

        public function automotive_car_dealer_getting_started() {
            $automotive_car_dealer_pro_features = array(
                esc_html__( 'Advanced Homepage Layouts', 'automotive-car-dealer' ),
                esc_html__( 'More Section Blocks & Customization', 'automotive-car-dealer' ),
                esc_html__( 'Premium Support', 'automotive-car-dealer' ),
                esc_html__( 'Regular Updates', 'automotive-car-dealer' ),
            );

            $automotive_car_dealer_support_topics = array(
                esc_html__( 'Theme Setup Support', 'automotive-car-dealer' ),
                esc_html__( 'Customization Help', 'automotive-car-dealer' ),
                esc_html__( 'Bug Fixes & Troubleshooting', 'automotive-car-dealer' ),
                esc_html__( 'General Questions', 'automotive-car-dealer' ),
            );
            ?>
            <?php if ( class_exists( 'Automotive_Car_Dealer_Demo_Import' ) && Automotive_Car_Dealer_Demo_Import::current_user_can_run() ) : ?>
                <?php $automotive_car_dealer_complete = Automotive_Car_Dealer_Demo_Import::is_complete(); ?>
                <div class="wprev-card wprev-import<?php echo $automotive_car_dealer_complete ? ' is-complete' : ''; ?>">
                    <span class="wprev-card__icon dashicons dashicons-<?php echo $automotive_car_dealer_complete ? 'yes-alt' : 'download'; ?>" aria-hidden="true"></span>
                    <div class="wprev-import__body">
                        <h3 class="wprev-card__title">
                            <?php $automotive_car_dealer_complete ? esc_html_e( 'Your Demo Is Ready', 'automotive-car-dealer' ) : esc_html_e( 'Plugin Installation & Demo Import', 'automotive-car-dealer' ); ?>
                        </h3>
                        <p>
                            <?php
                            $automotive_car_dealer_complete
                                ? esc_html_e( 'The recommended plugins are active and the demo products have been imported.', 'automotive-car-dealer' )
                                : esc_html_e( 'Install and activate the recommended plugins, including WooCommerce, and import the demo products shown on the homepage, all in one click.', 'automotive-car-dealer' );
                            ?>
                        </p>
                    </div>
                    <?php Automotive_Car_Dealer_Demo_Import::render_button( 'getstart' ); ?>
                </div>
            <?php endif; ?>

            <div class="wprev-cards">

                <div class="wprev-card wprev-card--preview">
                    <h3 class="wprev-card__title"><?php esc_html_e( 'Theme Preview', 'automotive-car-dealer' ); ?></h3>
                    <div class="wprev-card__shot">
                        <img src="<?php echo esc_url( $this->theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'automotive-car-dealer' ); ?>" />
                    </div>
                    <div class="wprev-card__actions">
                        <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_LIVE_DEMO ); ?>">
                            <?php esc_html_e( 'Live Demo', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                        </a>
                        <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Theme Details', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="wprev-card wprev-card--pro">
                    <h3 class="wprev-card__title wprev-card__title--pink">
                        <span class="dashicons dashicons-star-filled" aria-hidden="true"></span>
                        <?php esc_html_e( 'Upgrade to Pro Version', 'automotive-car-dealer' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Get more features, advanced sections, premium designs and priority support with the Pro version.', 'automotive-car-dealer' ); ?></p>
                    <ul class="wprev-checklist">
                        <?php foreach ( $automotive_car_dealer_pro_features as $automotive_car_dealer_feature ) : ?>
                            <li><?php echo esc_html( $automotive_car_dealer_feature ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="wprev-card__footer">
                        <span class="wprev-card__price"><?php esc_html_e( 'Only $39', 'automotive-car-dealer' ); ?></span>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Buy Pro Theme', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                    </div>
                    <?php $this->coupon(); ?>
                </div>

                <div class="wprev-card">
                    <h3 class="wprev-card__title">
                        <span class="wprev-card__icon dashicons dashicons-media-document" aria-hidden="true"></span>
                        <?php esc_html_e( 'Need Documentation?', 'automotive-car-dealer' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Check our detailed documentation for step-by-step guidance on installation, customization and using the Automotive Car Dealer theme.', 'automotive-car-dealer' ); ?></p>
                    <a class="wprev-btn wprev-btn--outline-blue" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_LITE_DOC ); ?>">
                        <?php esc_html_e( 'Go to Documentation', 'automotive-car-dealer' ); ?>
                        <span class="dashicons dashicons-external" aria-hidden="true"></span>
                    </a>
                    <div class="wprev-tip">
                        <span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
                        <p><strong><?php esc_html_e( 'Tip:', 'automotive-car-dealer' ); ?></strong> <?php esc_html_e( 'Need help setting up? Start with our documentation or contact our support team.', 'automotive-car-dealer' ); ?></p>
                    </div>
                </div>

                <div class="wprev-card wprev-card--support">
                    <h3 class="wprev-card__title">
                        <span class="wprev-card__icon wprev-card__icon--green dashicons dashicons-format-chat" aria-hidden="true"></span>
                        <?php esc_html_e( 'Need Support?', 'automotive-car-dealer' ); ?>
                    </h3>
                    <p><?php esc_html_e( 'Facing any issues or have questions? Our dedicated support team is here to help you.', 'automotive-car-dealer' ); ?></p>
                    <ul class="wprev-checklist wprev-checklist--green">
                        <?php foreach ( $automotive_car_dealer_support_topics as $automotive_car_dealer_topic ) : ?>
                            <li><?php echo esc_html( $automotive_car_dealer_topic ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="wprev-btn wprev-btn--outline-blue" target="_blank" rel="noopener" href="<?php echo esc_url( 'https://wordpress.org/support/theme/' . $this->theme_info( 'TextDomain' ) ); ?>">
                        <?php esc_html_e( 'Get Support', 'automotive-car-dealer' ); ?>
                        <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                    </a>
                </div>

            </div>
            <?php
        }

        public function coupon( $automotive_car_dealer_code = 'STARTUP20', $automotive_car_dealer_text = '' ) {
            if ( '' === $automotive_car_dealer_text ) {
                /* translators: %s: Coupon code. */
                $automotive_car_dealer_text = sprintf( esc_html__( 'Get Extra 20%% OFF Using "%s"', 'automotive-car-dealer' ), '<strong>' . esc_html( $automotive_car_dealer_code ) . '</strong>' );
            }
            ?>
            <div class="wprev-coupon">
                <p class="wprev-coupon__text">
                    <span class="dashicons dashicons-tickets-alt" aria-hidden="true"></span>
                    <span><?php echo wp_kses( $automotive_car_dealer_text, array( 'strong' => array() ) ); ?></span>
                </p>
                <div class="wprev-coupon__field">
                    <code class="wprev-coupon__code"><?php echo esc_html( $automotive_car_dealer_code ); ?></code>
                    <button type="button" class="wprev-coupon__copy" data-wprev-copy="<?php echo esc_attr( $automotive_car_dealer_code ); ?>">
                        <span class="dashicons dashicons-admin-page" aria-hidden="true"></span>
                        <span class="wprev-coupon__label"><?php esc_html_e( 'Copy Code', 'automotive-car-dealer' ); ?></span>
                    </button>
                </div>
                <span class="screen-reader-text" aria-live="polite" data-wprev-copy-status></span>
            </div>
            <?php
        }

        public function automotive_car_dealer_bundle() {
            $automotive_car_dealer_included = array(
                esc_html__( '60+ Premium WordPress Themes', 'automotive-car-dealer' ),
                esc_html__( 'Use on Unlimited Websites', 'automotive-car-dealer' ),
                esc_html__( 'All Future Themes Included', 'automotive-car-dealer' ),
                esc_html__( '1 Year of Updates & Premium Support', 'automotive-car-dealer' ),
                esc_html__( 'One-Click Demo Import', 'automotive-car-dealer' ),
                esc_html__( 'WooCommerce Ready Designs', 'automotive-car-dealer' ),
                esc_html__( 'Fully Responsive & SEO Friendly', 'automotive-car-dealer' ),
                esc_html__( 'Detailed Documentation', 'automotive-car-dealer' ),
            );

            $automotive_car_dealer_categories = array(
                esc_html__( 'eCommerce', 'automotive-car-dealer' ),
                esc_html__( 'Beauty & Spa', 'automotive-car-dealer' ),
                esc_html__( 'Business', 'automotive-car-dealer' ),
                esc_html__( 'Blog', 'automotive-car-dealer' ),
                esc_html__( 'Portfolio', 'automotive-car-dealer' ),
                esc_html__( 'Health & Fitness', 'automotive-car-dealer' ),
                esc_html__( 'Restaurant', 'automotive-car-dealer' ),
                esc_html__( 'Education', 'automotive-car-dealer' ),
            );

            $automotive_car_dealer_steps = array(
                esc_html__( 'Purchase the bundle', 'automotive-car-dealer' ),
                esc_html__( 'Download any theme from your account', 'automotive-car-dealer' ),
                esc_html__( 'Install, import the demo and launch', 'automotive-car-dealer' ),
            );
            ?>
            <div class="wprev-detail">
                <div class="wprev-detail__main">
                    <div class="wprev-card wprev-detail__intro">
                        <div class="wprev-detail__media" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/getstarted/assets/images/getstart-bundle.png' ); ?>" alt="" />
                        </div>
                        <div>
                            <p class="wprev-eyebrow"><?php esc_html_e( 'WordPress Theme Bundle', 'automotive-car-dealer' ); ?></p>
                            <h3 class="wprev-detail__title"><?php esc_html_e( 'Every Premium Theme. One Simple Price.', 'automotive-car-dealer' ); ?></h3>
                            <p><?php esc_html_e( 'The bundle gives you instant access to our entire collection of premium themes, so you can build websites for any niche or client without buying themes one by one.', 'automotive-car-dealer' ); ?></p>
                        </div>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title"><?php esc_html_e( "What's Included", 'automotive-car-dealer' ); ?></h3>
                        <ul class="wprev-checklist wprev-checklist--grid">
                            <?php foreach ( $automotive_car_dealer_included as $automotive_car_dealer_item ) : ?>
                                <li><?php echo esc_html( $automotive_car_dealer_item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title"><?php esc_html_e( 'Themes for Every Niche', 'automotive-car-dealer' ); ?></h3>
                        <ul class="wprev-chips">
                            <?php foreach ( $automotive_car_dealer_categories as $automotive_car_dealer_category ) : ?>
                                <li><?php echo esc_html( $automotive_car_dealer_category ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <ol class="wprev-steps">
                            <?php foreach ( $automotive_car_dealer_steps as $automotive_car_dealer_i => $automotive_car_dealer_step ) : ?>
                                <li><span><?php echo esc_html( $automotive_car_dealer_i + 1 ); ?></span><?php echo esc_html( $automotive_car_dealer_step ); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>

                <aside class="wprev-detail__aside">
                    <div class="wprev-cta">
                        <span class="wprev-ribbon"><?php esc_html_e( 'Best Value', 'automotive-car-dealer' ); ?></span>
                        <p class="wprev-cta__label"><?php esc_html_e( 'Complete Theme Bundle', 'automotive-car-dealer' ); ?></p>
                        <del><?php esc_html_e( '$2340', 'automotive-car-dealer' ); ?></del>
                        <strong class="wprev-cta__price"><?php esc_html_e( '$79', 'automotive-car-dealer' ); ?></strong>
                        <?php $this->coupon( 'BUNDLE10', sprintf( /* translators: %d: Discount percentage. */ esc_html__( 'Flat %d%% OFF on Bundle', 'automotive-car-dealer' ), 10 ) ); ?>
                        <a class="wprev-btn wprev-btn--pink" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUNDLE ); ?>">
                            <?php esc_html_e( 'Get the Bundle', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                        <ul class="wprev-cta__trust">
                            <li><span class="dashicons dashicons-lock" aria-hidden="true"></span><?php esc_html_e( 'Secure checkout', 'automotive-car-dealer' ); ?></li>
                            <li><span class="dashicons dashicons-update" aria-hidden="true"></span><?php esc_html_e( 'Instant access', 'automotive-car-dealer' ); ?></li>
                        </ul>
                    </div>
                </aside>
            </div>
            <?php
        }

        public function automotive_car_dealer_support() {
            $automotive_car_dealer_text_domain = $this->theme_info( 'TextDomain' );

            $automotive_car_dealer_channels = array(
                array(
                    'icon'  => 'WordPress',
                    'title' => esc_html__( 'Free Support Forum', 'automotive-car-dealer' ),
                    'desc'  => esc_html__( 'Ask questions about the free theme on the official wordpress.org forum.', 'automotive-car-dealer' ),
                    'label' => esc_html__( 'Open Forum', 'automotive-car-dealer' ),
                    'url'   => 'https://wordpress.org/support/theme/' . $automotive_car_dealer_text_domain,
                ),
                array(
                    'icon'  => 'media-document',
                    'title' => esc_html__( 'Documentation', 'automotive-car-dealer' ),
                    'desc'  => esc_html__( 'Step-by-step guides for installation, setup and customization.', 'automotive-car-dealer' ),
                    'label' => esc_html__( 'Read Docs', 'automotive-car-dealer' ),
                    'url'   => AUTOMOTIVE_CAR_DEALER_LITE_DOC,
                ),
                array(
                    'icon'  => 'star-filled',
                    'title' => esc_html__( 'Rate & Review', 'automotive-car-dealer' ),
                    'desc'  => esc_html__( 'Enjoying the theme? A quick review helps us keep improving it.', 'automotive-car-dealer' ),
                    'label' => esc_html__( 'Leave a Review', 'automotive-car-dealer' ),
                    'url'   => AUTOMOTIVE_CAR_DEALER_REVIEW,
                ),
            );

            $automotive_car_dealer_topics = array(
                esc_html__( 'Theme Setup Support', 'automotive-car-dealer' ),
                esc_html__( 'Customization Help', 'automotive-car-dealer' ),
                esc_html__( 'Bug Fixes & Troubleshooting', 'automotive-car-dealer' ),
                esc_html__( 'Plugin Compatibility', 'automotive-car-dealer' ),
                esc_html__( 'Demo Content Import', 'automotive-car-dealer' ),
                esc_html__( 'General Questions', 'automotive-car-dealer' ),
            );
            ?>
            <div class="wprev-detail">
                <div class="wprev-detail__main">
                    <div class="wprev-support-grid">
                        <?php foreach ( $automotive_car_dealer_channels as $automotive_car_dealer_channel ) : ?>
                            <div class="wprev-card">
                                <h3 class="wprev-card__title">
                                    <span class="wprev-card__icon dashicons dashicons-<?php echo esc_attr( strtolower( $automotive_car_dealer_channel['icon'] ) ); ?>" aria-hidden="true"></span>
                                    <?php echo esc_html( $automotive_car_dealer_channel['title'] ); ?>
                                </h3>
                                <p><?php echo esc_html( $automotive_car_dealer_channel['desc'] ); ?></p>
                                <a class="wprev-btn wprev-btn--outline-blue wprev-card__cta" target="_blank" rel="noopener" href="<?php echo esc_url( $automotive_car_dealer_channel['url'] ); ?>">
                                    <?php echo esc_html( $automotive_car_dealer_channel['label'] ); ?>
                                    <span class="dashicons dashicons-external" aria-hidden="true"></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="wprev-card">
                        <h3 class="wprev-card__title">
                            <span class="wprev-card__icon wprev-card__icon--green dashicons dashicons-format-chat" aria-hidden="true"></span>
                            <?php esc_html_e( 'What We Can Help With', 'automotive-car-dealer' ); ?>
                        </h3>
                        <ul class="wprev-checklist wprev-checklist--green wprev-checklist--grid">
                            <?php foreach ( $automotive_car_dealer_topics as $automotive_car_dealer_topic ) : ?>
                                <li><?php echo esc_html( $automotive_car_dealer_topic ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="wprev-tip">
                            <span class="dashicons dashicons-lightbulb" aria-hidden="true"></span>
                            <p><strong><?php esc_html_e( 'Tip:', 'automotive-car-dealer' ); ?></strong> <?php esc_html_e( 'Include your WordPress version, theme version and a screenshot or link to the issue so we can help faster.', 'automotive-car-dealer' ); ?></p>
                        </div>
                    </div>
                </div>

                <aside class="wprev-detail__aside">
                    <div class="wprev-cta wprev-cta--blue">
                        <span class="wprev-card__icon dashicons dashicons-sos" aria-hidden="true"></span>
                        <p class="wprev-cta__label"><?php esc_html_e( 'Need Priority Help?', 'automotive-car-dealer' ); ?></p>
                        <p class="wprev-cta__note"><?php esc_html_e( 'Pro users get fast, one-to-one premium support from our theme experts.', 'automotive-car-dealer' ); ?></p>
                        <a class="wprev-btn wprev-btn--blue" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_PRO_SUPPORT ); ?>">
                            <?php esc_html_e( 'Contact Support', 'automotive-car-dealer' ); ?>
                            <span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
                        </a>
                        <a class="wprev-btn wprev-btn--outline" target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ); ?>">
                            <?php esc_html_e( 'Upgrade to Pro', 'automotive-car-dealer' ); ?>
                        </a>
                    </div>
                </aside>
            </div>
            <?php
        }

		public function automotive_car_dealer_free_pro() {
            ?>
            <div class="wprev-compare-wrap">
            <table class="wprev-compare">
                <tbody class="table-body">
                    <tr class="table-head">
                        <th class="large"><?php echo esc_html__( 'Features', 'automotive-car-dealer' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Free theme', 'automotive-car-dealer' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'automotive-car-dealer' ); ?></th>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Responsive Design', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Site Logo upload', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Footer Copyright text', 'automotive-car-dealer' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'automotive-car-dealer' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Global Color', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Regular Bug Fixes', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Theme Sections', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'automotive-car-dealer' ); ?></span></td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'automotive-car-dealer' ); ?></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom colors', 'automotive-car-dealer' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'automotive-car-dealer' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Google fonts', 'automotive-car-dealer' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'automotive-car-dealer' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Enhanced Plugin Integration', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Fully SEO Optimized', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Premium Support', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Extensive Customization', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom Post Types', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'automotive-car-dealer' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes"></span></td>
                    </tr>

                    <tr class="upsell-row">
                        <td></td>
                        <td><span class="abc"><?php echo esc_html__( 'Try Out Our Premium Version', 'automotive-car-dealer' ); ?></span></td>
                        <td>
                            <a target="_blank" rel="noopener" href="<?php echo esc_url( AUTOMOTIVE_CAR_DEALER_BUY_NOW ); ?>" class="wprev-btn wprev-btn--pink"><?php echo esc_html__( 'Buy Pro Theme', 'automotive-car-dealer' ); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <?php
        }

		public function changelog() {
            require get_theme_file_path( 'getstarted/automotive_car_dealer_changelog.php' );
        }
	}

}
new automotive_car_dealer_Welcome();
