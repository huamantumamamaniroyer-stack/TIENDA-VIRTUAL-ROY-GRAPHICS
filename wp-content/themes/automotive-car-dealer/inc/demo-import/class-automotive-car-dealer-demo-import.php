<?php
/**
 * One-click "Plugin Installation & Demo Import".
 *
 * Installs and activates the plugins registered through TGMPA, then imports the demo
 * WooCommerce products shown in the homepage Products section. Every step is a
 * separate AJAX request so long-running work never hits a single request timeout.
 *
 * @package Automotive Car Dealer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Automotive_Car_Dealer_Demo_Import' ) ) {

	/**
	 * Handles the one-click setup flow.
	 */
	final class Automotive_Car_Dealer_Demo_Import {

		/**
		 * AJAX action prefix, nonce action and script handle.
		 */
		const PREFIX = 'automotive_car_dealer_demo_';
		const NONCE  = 'automotive_car_dealer_demo_import';
		const HANDLE = 'automotive-car-dealer-demo-import';

		/**
		 * Meta keys marking imported demo content, used to find it again on re-runs.
		 */
		const PRODUCT_META = '_automotive_car_dealer_demo_key';
		const IMAGE_META   = '_automotive_car_dealer_demo_image';

		/**
		 * Option storing the time the setup last completed.
		 */
		const DONE_OPTION = 'automotive_car_dealer_demo_import_done';

		/**
		 * Returns the instance.
		 *
		 * @return Automotive_Car_Dealer_Demo_Import
		 */
		public static function get_instance() {
			static $instance = null;

			if ( null === $instance ) {
				$instance = new self();
			}

			return $instance;
		}

		/**
		 * Registers hooks.
		 */
		private function __construct() {
			add_filter( 'tgmpa_load', array( $this, 'load_tgmpa_for_ajax' ) );
			add_filter( 'wp_redirect', array( $this, 'block_redirects_during_ajax' ), PHP_INT_MAX );
			add_action( 'admin_init', array( $this, 'clear_setup_redirects_for_flow' ), 1 );

			foreach ( array( 'status', 'install_plugin', 'activate_plugin', 'import_product', 'finish' ) as $step ) {
				add_action( 'wp_ajax_' . self::PREFIX . $step, array( $this, 'ajax_' . $step ) );
			}
		}

		/**
		 * TGMPA does not load during AJAX by default; enable it for this flow's requests only.
		 *
		 * @param bool $load Whether TGMPA should load.
		 * @return bool
		 */
		public function load_tgmpa_for_ajax( $load ) {
			return self::is_flow_request() ? true : $load;
		}

		/**
		 * Cancels redirects during this flow's requests.
		 *
		 * Some plugins redirect to their setup wizard on the first admin request after activation,
		 * even during AJAX (WP Travel does this on admin_init). The browser follows the redirect and
		 * the step receives an HTML page instead of JSON, which stops the import.
		 *
		 * @param string|false $location Redirect target.
		 * @return string|false
		 */
		public function block_redirects_during_ajax( $location ) {
			return self::is_flow_request() ? false : $location;
		}

		/**
		 * Clears setup-wizard redirect flags before plugins act on them during this flow's requests.
		 *
		 * Runs on admin_init before plugins (priority 1). Plugins such as Essential Real Estate
		 * redirect and exit on the first admin request after activation, which leaves the step
		 * with an empty or HTML response.
		 */
		public function clear_setup_redirects_for_flow() {
			if ( self::is_flow_request() ) {
				self::clear_setup_redirects();
			}
		}

		/**
		 * Deletes the flags plugins set on activation to redirect to their setup wizard.
		 *
		 * Most use a "_<plugin>_activation_redirect" transient (WooCommerce, Essential Real Estate);
		 * WP Travel uses an option.
		 */
		private static function clear_setup_redirects() {
			global $wpdb;

			$like  = $wpdb->esc_like( '_transient_' ) . '%' . $wpdb->esc_like( 'activation_redirect' ) . '%';
			$names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $like ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery -- Transient names are not known in advance.

			foreach ( $names as $name ) {
				delete_transient( substr( $name, strlen( '_transient_' ) ) );
			}

			// Also when transients live in an object cache instead of the options table.
			delete_transient( '_wc_activation_redirect' );
			delete_transient( '_ere_activation_redirect' );
			delete_option( 'wp_travel_setup_page_redirect' );
		}

		/**
		 * Whether the current request is one of this flow's AJAX steps.
		 *
		 * @return bool
		 */
		private static function is_flow_request() {
			return wp_doing_ajax() && isset( $_REQUEST['action'] ) && 0 === strpos( sanitize_key( wp_unslash( $_REQUEST['action'] ) ), self::PREFIX ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only decides how the request is handled; every handler verifies the nonce.
		}

		/**
		 * Whether the current user may run the whole flow.
		 *
		 * @return bool
		 */
		public static function current_user_can_run() {
			return current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) && current_user_can( 'manage_options' );
		}

		/**
		 * Whether the setup has completed and WooCommerce is still active.
		 *
		 * @return bool
		 */
		public static function is_complete() {
			return get_option( self::DONE_OPTION ) && class_exists( 'WooCommerce' );
		}

		/**
		 * Returns the next thing the setup has to do, so the button can say so:
		 * "install" (a plugin is missing), "activate" (all installed, one inactive),
		 * "import" (plugins active, demo not imported yet) or "complete".
		 *
		 * @return string
		 */
		public static function get_setup_state() {
			if ( self::is_complete() ) {
				return 'complete';
			}

			if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
				return class_exists( 'WooCommerce' ) ? 'import' : 'install';
			}

			$tgmpa = TGM_Plugin_Activation::get_instance();

			if ( empty( $tgmpa->plugins ) || ! is_array( $tgmpa->plugins ) ) {
				return class_exists( 'WooCommerce' ) ? 'import' : 'install';
			}

			$tgmpa->populate_file_path();

			$state = 'import';

			foreach ( array_keys( $tgmpa->plugins ) as $slug ) {
				if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
					return 'install';
				}

				if ( ! $tgmpa->is_plugin_active( $slug ) ) {
					$state = 'activate';
				}
			}

			return $state;
		}

		/**
		 * Button labels for each setup state.
		 *
		 * @return string[]
		 */
		private static function get_button_labels() {
			return array(
				'install'  => __( 'Plugin Installation & Demo Import', 'automotive-car-dealer' ),
				'activate' => __( 'Activate Plugins & Import Demo', 'automotive-car-dealer' ),
				'import'   => __( 'Import Demo Products', 'automotive-car-dealer' ),
				'complete' => __( 'Run setup again', 'automotive-car-dealer' ),
			);
		}

		/**
		 * Outputs the one-click button and enqueues its script.
		 *
		 * @param string $context Extra class for the wrapper, e.g. "notice" or "getstart".
		 */
		public static function render_button( $context = '' ) {
			if ( ! self::current_user_can_run() ) {
				return;
			}

			self::enqueue_script();

			$state    = self::get_setup_state();
			$complete = 'complete' === $state;
			$labels   = self::get_button_labels();
			$label    = $labels[ $state ];
			?>
			<div class="wprev-demo-import is-state-<?php echo esc_attr( $state ); ?><?php echo $context ? ' is-' . esc_attr( $context ) : ''; ?>">
				<?php if ( $complete ) : ?>
					<a class="button button-primary wprev-demo-import-visit" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Site', 'automotive-car-dealer' ); ?></a>
				<?php endif; ?>
				<button type="button" class="button <?php echo $complete ? 'button-link wprev-demo-import-rerun' : 'button-primary'; ?> wprev-demo-import-button" data-label="<?php echo esc_attr( $complete ? $labels['install'] : $label ); ?>">
					<?php echo esc_html( $label ); ?>
				</button>
				<p class="wprev-demo-import-status" role="status" aria-live="polite"></p>
			</div>
			<?php
		}

		/**
		 * Enqueues the flow's script once per page.
		 */
		private static function enqueue_script() {
			if ( wp_script_is( self::HANDLE, 'enqueued' ) ) {
				return;
			}

			wp_enqueue_script(
				self::HANDLE,
				get_template_directory_uri() . '/assets/js/demo-import.js',
				array(),
				AUTOMOTIVE_CAR_DEALER_VERSION,
				true
			);

			wp_localize_script(
				self::HANDLE,
				'automotiveCarDealerDemoImport',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( self::NONCE ),
					'prefix'  => self::PREFIX,
					'redirect' => admin_url( 'themes.php?page=automotive-car-dealer-getstart-page' ),
					'i18n'    => array(
						'start'           => __( 'Plugin Installation & Demo Import', 'automotive-car-dealer' ),
						'checking'        => __( 'Checking Plugins...', 'automotive-car-dealer' ),
						'installing'      => __( 'Installing Plugins...', 'automotive-car-dealer' ),
						'activating'      => __( 'Activating Plugins...', 'automotive-car-dealer' ),
						'importing'       => __( 'Importing Demo Products...', 'automotive-car-dealer' ),
						'finishing'       => __( 'Finishing Setup...', 'automotive-car-dealer' ),
						'visit'           => __( 'Visit Site', 'automotive-car-dealer' ),
						/* translators: 1: Plugin name, 2: Current position, 3: Total. */
						'installingOne'   => __( 'Installing %1$s (%2$d of %3$d)', 'automotive-car-dealer' ),
						/* translators: 1: Plugin name, 2: Current position, 3: Total. */
						'activatingOne'   => __( 'Activating %1$s (%2$d of %3$d)', 'automotive-car-dealer' ),
						/* translators: 1: Product name, 2: Current position, 3: Total. */
						'importingOne'    => __( 'Importing %1$s (%2$d of %3$d)', 'automotive-car-dealer' ),
						/* translators: %s: Plugin name. */
						'notInstalled'    => __( '%1$s could not be installed.', 'automotive-car-dealer' ),
						/* translators: %s: Plugin name. */
						'notActive'       => __( '%1$s could not be activated, so the demo products were not imported.', 'automotive-car-dealer' ),
						'noWooCommerce'   => __( 'WooCommerce is not active, so the demo products cannot be imported.', 'automotive-car-dealer' ),
						'done'            => __( 'All done! Plugins are active and the demo products have been imported.', 'automotive-car-dealer' ),
						'redirecting'     => __( 'All done! Taking you to the Getting Started page...', 'automotive-car-dealer' ),
						'productsFailed'  => __( 'Some demo products could not be imported. Click the button to retry; products that were already imported will not be duplicated.', 'automotive-car-dealer' ),
						'genericError'    => __( 'Something went wrong. Please try again.', 'automotive-car-dealer' ),
						'invalidResponse' => __( 'The server returned an unexpected response. Please try again.', 'automotive-car-dealer' ),
						'retryHint'       => __( 'Click the button to retry.', 'automotive-car-dealer' ),
					),
				)
			);
		}

		/* -----------------------------------------------------------------
		 * AJAX handlers
		 * -------------------------------------------------------------- */

		/**
		 * Returns the TGMPA plugins with their state, WooCommerce availability and product list.
		 */
		public function ajax_status() {
			$this->verify_request();

			$products = array();
			foreach ( automotive_car_dealer_get_demo_products() as $product ) {
				$products[] = array( 'name' => $product['name'] );
			}

			$this->send_success(
				array(
					'plugins'     => $this->get_plugins_state(),
					'woocommerce' => class_exists( 'WooCommerce' ),
					'products'    => $products,
				)
			);
		}

		/**
		 * Installs one TGMPA plugin.
		 */
		public function ajax_install_plugin() {
			$this->verify_request( 'install_plugins' );

			$tgmpa = $this->get_tgmpa();
			$slug  = $this->get_requested_slug( $tgmpa );

			if ( $tgmpa->is_plugin_installed( $slug ) ) {
				$this->send_success( array( 'slug' => $slug ) );
			}

			$source = $tgmpa->get_download_url( $slug );

			if ( empty( $source ) ) {
				/* translators: %s: Plugin name. */
				$this->send_error( sprintf( __( 'Could not find a download for %s.', 'automotive-car-dealer' ), $tgmpa->plugins[ $slug ]['name'] ) );
			}

			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/misc.php';
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

			$skin     = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Plugin_Upgrader( $skin );
			$result   = $upgrader->install( $source );

			if ( is_wp_error( $result ) ) {
				$this->send_error( $result->get_error_message() );
			}

			if ( is_wp_error( $skin->result ) ) {
				$this->send_error( $skin->result->get_error_message() );
			}

			if ( $skin->get_errors()->has_errors() ) {
				$this->send_error( $skin->get_error_messages() );
			}

			if ( ! $result ) {
				global $wp_filesystem;

				if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
					$this->send_error( $wp_filesystem->errors->get_error_message() );
				}

				/* translators: %s: Plugin name. */
				$this->send_error( sprintf( __( 'Unable to install %s. Please check the file permissions of the plugins folder.', 'automotive-car-dealer' ), $tgmpa->plugins[ $slug ]['name'] ) );
			}

			wp_clean_plugins_cache();
			$tgmpa->populate_file_path( $slug );

			if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
				/* translators: %s: Plugin name. */
				$this->send_error( sprintf( __( '%s was downloaded but could not be found in the plugins folder.', 'automotive-car-dealer' ), $tgmpa->plugins[ $slug ]['name'] ) );
			}

			$this->send_success( array( 'slug' => $slug ) );
		}

		/**
		 * Activates one TGMPA plugin.
		 */
		public function ajax_activate_plugin() {
			$this->verify_request( 'activate_plugins' );

			$tgmpa = $this->get_tgmpa();
			$slug  = $this->get_requested_slug( $tgmpa );
			$name  = $tgmpa->plugins[ $slug ]['name'];

			if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
				/* translators: %s: Plugin name. */
				$this->send_error( sprintf( __( '%s is not installed.', 'automotive-car-dealer' ), $name ) );
			}

			if ( $tgmpa->is_plugin_active( $slug ) ) {
				$this->send_success( array( 'slug' => $slug ) );
			}

			if ( $tgmpa->does_plugin_require_update( $slug ) ) {
				/* translators: %s: Plugin name. */
				$this->send_error( sprintf( __( 'A newer version of %s is required. Please update it from the Plugins screen.', 'automotive-car-dealer' ), $name ) );
			}

			$result = activate_plugin( $tgmpa->plugins[ $slug ]['file_path'] );

			/*
			 * "unexpected_output" is only a warning: WordPress has already activated the plugin
			 * (the Plugins screen treats it the same way). WooCommerce triggers it on a fresh site
			 * when debug display is on, because its tables do not exist until it has installed.
			 */
			if ( is_wp_error( $result ) && ( 'unexpected_output' !== $result->get_error_code() || ! is_plugin_active( $tgmpa->plugins[ $slug ]['file_path'] ) ) ) {
				$this->send_error( $result->get_error_message() );
			}

			// Keep the plugin from redirecting the next admin page load to its setup wizard.
			self::clear_setup_redirects();

			$this->send_success( array( 'slug' => $slug ) );
		}

		/**
		 * Imports (or finds the existing copy of) one demo product.
		 */
		public function ajax_import_product() {
			$this->verify_request();

			if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WC_Product_Simple' ) ) {
				$this->send_error( __( 'WooCommerce is not active, so the demo products cannot be imported.', 'automotive-car-dealer' ) );
			}

			$products = automotive_car_dealer_get_demo_products();
			$index    = isset( $_POST['index'] ) ? absint( wp_unslash( $_POST['index'] ) ) : -1; // phpcs:ignore wordpress.Security.NonceVerification.Missing -- Verified in verify_request().

			if ( ! isset( $products[ $index ] ) ) {
				$this->send_error( __( 'Unknown demo product.', 'automotive-car-dealer' ) );
			}

			$result = $this->import_product( $products[ $index ], $index );

			if ( is_wp_error( $result ) ) {
				$this->send_error( $result->get_error_message() );
			}

			$this->send_success( $result );
		}

		/**
		 * Completes the setup.
		 */
		public function ajax_finish() {
			$this->verify_request();

			if ( ! class_exists( 'WooCommerce' ) ) {
				$this->send_error( __( 'WooCommerce is not active.', 'automotive-car-dealer' ) );
			}

			foreach ( $this->get_plugins_state() as $plugin ) {
				if ( ! $plugin['active'] ) {
					/* translators: %s: Plugin name. */
					$this->send_error( sprintf( __( '%s is not active.', 'automotive-car-dealer' ), $plugin['name'] ) );
				}
			}

			foreach ( automotive_car_dealer_get_demo_products() as $product ) {
				if ( ! $this->find_product( $product['key'] ) ) {
					/* translators: %s: Product name. */
					$this->send_error( sprintf( __( 'The demo product "%s" is missing.', 'automotive-car-dealer' ), $product['name'] ) );
				}
			}

			if ( function_exists( 'wc_delete_product_transients' ) ) {
				wc_delete_product_transients();
			}

			update_option( self::DONE_OPTION, time(), false );

			$this->send_success( array( 'url' => home_url( '/' ) ) );
		}

		/* -----------------------------------------------------------------
		 * Helpers
		 * -------------------------------------------------------------- */

		/**
		 * Checks the nonce and capability, and starts buffering so stray output
		 * (PHP notices, plugin activation output) cannot corrupt the JSON response.
		 *
		 * @param string $capability Extra capability required for this step.
		 */
		private function verify_request( $capability = '' ) {
			ob_start();

			if ( false === check_ajax_referer( self::NONCE, 'nonce', false ) ) {
				$this->send_error( __( 'Your session has expired. Please reload the page and try again.', 'automotive-car-dealer' ), 403 );
			}

			if ( ! self::current_user_can_run() || ( $capability && ! current_user_can( $capability ) ) ) {
				$this->send_error( __( 'You do not have permission to do this.', 'automotive-car-dealer' ), 403 );
			}
		}

		/**
		 * Discards buffered output and sends a JSON success response.
		 *
		 * @param mixed $data Response data.
		 */
		private function send_success( $data = null ) {
			$this->discard_output();
			wp_send_json_success( $data );
		}

		/**
		 * Discards buffered output and sends a JSON error response.
		 *
		 * @param string $message Error message.
		 * @param int    $status  HTTP status code.
		 */
		private function send_error( $message, $status = 200 ) {
			$this->discard_output();
			wp_send_json_error( array( 'message' => wp_strip_all_tags( $message ) ), $status );
		}

		/**
		 * Closes every output buffer opened during this request.
		 */
		private function discard_output() {
			while ( ob_get_level() > 0 ) {
				ob_end_clean();
			}
		}

		/**
		 * Returns the TGMPA instance, or stops with an error.
		 *
		 * @return TGM_Plugin_Activation
		 */
		private function get_tgmpa() {
			if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
				$this->send_error( __( 'The plugin installer is not available.', 'automotive-car-dealer' ) );
			}

			$tgmpa = TGM_Plugin_Activation::get_instance();

			if ( empty( $tgmpa->plugins ) || ! is_array( $tgmpa->plugins ) ) {
				$tgmpa->plugins = array();
			}

			return $tgmpa;
		}

		/**
		 * Returns the requested slug if it is registered with TGMPA, or stops with an error.
		 *
		 * @param TGM_Plugin_Activation $tgmpa TGMPA instance.
		 * @return string
		 */
		private function get_requested_slug( $tgmpa ) {
			$slug = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : ''; // phpcs:ignore wordpress.Security.NonceVerification.Missing -- Verified in verify_request().

			if ( '' === $slug || ! isset( $tgmpa->plugins[ $slug ] ) ) {
				$this->send_error( __( 'This plugin is not part of the theme setup.', 'automotive-car-dealer' ) );
			}

			return $slug;
		}

		/**
		 * Returns the state of every TGMPA plugin.
		 *
		 * @return array[]
		 */
		private function get_plugins_state() {
			$tgmpa   = $this->get_tgmpa();
			$plugins = array();

			wp_clean_plugins_cache( false );
			$tgmpa->populate_file_path();

			foreach ( $tgmpa->plugins as $slug => $plugin ) {
				$plugins[] = array(
					'slug'      => $slug,
					'name'      => $plugin['name'],
					'required'  => (bool) $plugin['required'],
					'installed' => $tgmpa->is_plugin_installed( $slug ),
					'active'    => $tgmpa->is_plugin_active( $slug ),
				);
			}

			return $this->order_by_dependencies( $plugins );
		}

		/**
		 * Puts every plugin after the plugins it needs (its "Requires Plugins" header).
		 *
		 * TGMPA sorts plugins by name, so a plugin such as "FOX – Currency Switcher" would be
		 * activated before WooCommerce, and WordPress refuses to activate a plugin whose
		 * required plugins are still inactive.
		 *
		 * @param array[] $plugins Plugins as returned by get_plugins_state().
		 * @return array[]
		 */
		private function order_by_dependencies( $plugins ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			$tgmpa     = $this->get_tgmpa();
			$installed = get_plugins();
			$by_slug   = array();
			$requires  = array();

			foreach ( $plugins as $plugin ) {
				$slug   = $plugin['slug'];
				$file   = $tgmpa->plugins[ $slug ]['file_path'];
				$header = isset( $installed[ $file ]['RequiresPlugins'] ) ? $installed[ $file ]['RequiresPlugins'] : '';

				$by_slug[ $slug ]  = $plugin;
				$requires[ $slug ] = array_filter( array_map( 'trim', explode( ',', $header ) ) );
			}

			$ordered = array();
			foreach ( array_keys( $by_slug ) as $slug ) {
				$this->add_with_dependencies( $slug, $by_slug, $requires, $ordered, array() );
			}

			return array_values( $ordered );
		}

		/**
		 * Adds a plugin to the ordered list after the plugins it requires.
		 *
		 * @param string  $slug     Plugin slug.
		 * @param array[] $by_slug  Plugins keyed by slug.
		 * @param array[] $requires Required slugs keyed by plugin slug.
		 * @param array[] $ordered  Ordered plugins, keyed by slug.
		 * @param bool[]  $visiting Slugs on the current path, to stop circular requirements.
		 */
		private function add_with_dependencies( $slug, $by_slug, $requires, &$ordered, $visiting ) {
			if ( isset( $ordered[ $slug ] ) || isset( $visiting[ $slug ] ) ) {
				return;
			}

			$visiting[ $slug ] = true;

			foreach ( $requires[ $slug ] as $dependency ) {
				if ( isset( $by_slug[ $dependency ] ) ) {
					$this->add_with_dependencies( $dependency, $by_slug, $requires, $ordered, $visiting );
				}
			}

			$ordered[ $slug ] = $by_slug[ $slug ];
		}

		/**
		 * Finds an imported demo product by its key.
		 *
		 * @param string $key Demo product key.
		 * @return int Product ID, or 0.
		 */
		private function find_product( $key ) {
			$ids = get_posts(
				array(
					'post_type'        => 'product',
					'post_status'      => array( 'publish', 'future', 'draft', 'pending', 'private' ),
					'meta_key'         => self::PRODUCT_META, // phpcs:ignore wordpress.DB.SlowDBQuery.slow_db_query_meta_key
					'meta_value'       => $key, // phpcs:ignore wordpress.DB.SlowDBQuery.slow_db_query_meta_value
					'fields'           => 'ids',
					'posts_per_page'   => 1,
					'no_found_rows'    => true,
					'suppress_filters' => true,
				)
			);

			return $ids ? (int) $ids[0] : 0;
		}

		/**
		 * Creates a demo product, or completes an existing one without touching user edits.
		 *
		 * @param array $data  Demo product definition.
		 * @param int   $index Position in the list; earlier products get newer dates so the section keeps its order.
		 * @return array|WP_Error
		 */
		private function import_product( $data, $index ) {
			$key = sanitize_key( $data['key'] );

			// Simple lock so two overlapping requests cannot both create the same product.
			$lock = 'automotive_car_dealer_demo_lock_' . $key;
			if ( get_transient( $lock ) ) {
				return new WP_Error( 'locked', __( 'This product is already being imported. Please wait a moment and try again.', 'automotive-car-dealer' ) );
			}
			set_transient( $lock, 1, MINUTE_IN_SECONDS );

			$existing_id = $this->find_product( $key );
			$product     = $existing_id ? wc_get_product( $existing_id ) : new WC_Product_Simple();

			if ( ! $product ) {
				delete_transient( $lock );
				/* translators: %s: Product name. */
				return new WP_Error( 'invalid_product', sprintf( __( 'Could not load the existing demo product "%s".', 'automotive-car-dealer' ), $data['name'] ) );
			}

			try {
				if ( ! $existing_id ) {
					$product->set_name( $data['name'] );
					$product->set_status( 'publish' );
					$product->set_catalog_visibility( 'visible' );
					$product->set_regular_price( $data['regular_price'] );
					$product->set_description( $data['description'] );
					$product->set_short_description( $data['short_description'] );
					$product->set_stock_status( 'instock' );
					$product->set_date_created( time() - ( $index * MINUTE_IN_SECONDS ) );
					$product->set_category_ids( $this->get_category_ids( $data['categories'] ) );
				}

				// Images are (re)attached only when missing, so a failed image can be retried.
				if ( ! $product->get_image_id() && ! empty( $data['image'] ) ) {
					$image_id = $this->import_image( $data['image'] );

					if ( is_wp_error( $image_id ) ) {
						throw new Exception( $image_id->get_error_message() );
					}

					$product->set_image_id( $image_id );
				}

				if ( ! $product->get_gallery_image_ids() && ! empty( $data['gallery'] ) ) {
					$gallery_ids = array();

					foreach ( $data['gallery'] as $file ) {
						$gallery_id = $this->import_image( $file );

						if ( is_wp_error( $gallery_id ) ) {
							throw new Exception( $gallery_id->get_error_message() );
						}

						$gallery_ids[] = $gallery_id;
					}

					$product->set_gallery_image_ids( $gallery_ids );
				}

				$product_id = $product->save();
			} catch ( Exception $e ) {
				delete_transient( $lock );

				/* translators: 1: Product name, 2: Error message. */
				return new WP_Error( 'import_failed', sprintf( __( 'Could not import "%1$s": %2$s', 'automotive-car-dealer' ), $data['name'], $e->getMessage() ) );
			}

			if ( ! $product_id ) {
				delete_transient( $lock );
				/* translators: %s: Product name. */
				return new WP_Error( 'import_failed', sprintf( __( 'Could not save "%s".', 'automotive-car-dealer' ), $data['name'] ) );
			}

			update_post_meta( $product_id, self::PRODUCT_META, $key );
			delete_transient( $lock );

			return array(
				'id'      => $product_id,
				'created' => ! $existing_id,
			);
		}

		/**
		 * Returns product category IDs, creating missing terms. The first category is
		 * the parent of the ones that follow it.
		 *
		 * @param string[] $names Category names.
		 * @return int[]
		 */
		private function get_category_ids( $names ) {
			$ids    = array();
			$parent = 0;

			foreach ( $names as $position => $name ) {
				$term = term_exists( $name, 'product_cat', $parent );

				if ( ! $term ) {
					$term = wp_insert_term( $name, 'product_cat', array( 'parent' => $parent ) );
				}

				if ( is_wp_error( $term ) ) {
					// A category is not essential; skip it rather than failing the product.
					continue;
				}

				$ids[] = (int) $term['term_id'];

				if ( 0 === $position ) {
					$parent = (int) $term['term_id'];
				}
			}

			return $ids;
		}

		/**
		 * Copies an image from the theme's assets/images directory into the media library,
		 * reusing the attachment created by an earlier run.
		 *
		 * @param string $file File name inside assets/images.
		 * @return int|WP_Error Attachment ID.
		 */
		private function import_image( $file ) {
			$file = sanitize_file_name( wp_basename( $file ) );

			$existing = get_posts(
				array(
					'post_type'        => 'attachment',
					'post_status'      => 'inherit',
					'meta_key'         => self::IMAGE_META, // phpcs:ignore wordpress.DB.SlowDBQuery.slow_db_query_meta_key
					'meta_value'       => $file, // phpcs:ignore wordpress.DB.SlowDBQuery.slow_db_query_meta_value
					'fields'           => 'ids',
					'posts_per_page'   => 1,
					'no_found_rows'    => true,
					'suppress_filters' => true,
				)
			);

			if ( $existing && get_attached_file( $existing[0] ) && file_exists( get_attached_file( $existing[0] ) ) ) {
				return (int) $existing[0];
			}

			// get_theme_file_path() lets a child theme provide its own image.
			$path = get_theme_file_path( 'assets/images/' . $file );

			if ( ! is_readable( $path ) ) {
				/* translators: %s: File name. */
				return new WP_Error( 'missing_image', sprintf( __( 'The image %s is missing from the theme.', 'automotive-car-dealer' ), $file ) );
			}

			$filetype = wp_check_filetype( $file );

			if ( empty( $filetype['type'] ) || 0 !== strpos( $filetype['type'], 'image/' ) ) {
				/* translators: %s: File name. */
				return new WP_Error( 'invalid_image', sprintf( __( '%s is not a supported image.', 'automotive-car-dealer' ), $file ) );
			}

			$upload = wp_upload_bits( $file, null, file_get_contents( $path ) ); // phpcs:ignore wordpress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local theme file.

			if ( ! empty( $upload['error'] ) ) {
				return new WP_Error( 'upload_failed', $upload['error'] );
			}

			$attachment_id = wp_insert_attachment(
				array(
					'post_mime_type' => $filetype['type'],
					'post_title'     => sanitize_text_field( pathinfo( $file, PATHINFO_FILENAME ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				),
				$upload['file'],
				0,
				true
			);

			if ( is_wp_error( $attachment_id ) ) {
				wp_delete_file( $upload['file'] );
				return $attachment_id;
			}

			require_once ABSPATH . 'wp-admin/includes/image.php';
			wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
			update_post_meta( $attachment_id, self::IMAGE_META, $file );

			return (int) $attachment_id;
		}
	}

	Automotive_Car_Dealer_Demo_Import::get_instance();
}
