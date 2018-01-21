<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

// if ( class_exists( 'PMPro_Expiration_Dates_Welcome' ) ) {
new PMPro_Expiration_Dates_Welcome();
// }
/**
 * PMPro Expiration Dates welcome splash
 * Remember to add to the base plugin file
register_activation_hook( __FILE__, 'welcome_screen_activate' );
function welcome_screen_activate() {
	set_transient( '_pmpro_expiration_dates', true, 30 );
}
 */
class PMPro_Expiration_Dates_Welcome {

	/**
	 * Add the min caps used for the plugin
	 */
	const min_caps = 'manage_options';

	/**
	 * Paulund_Plugin_Welcome constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'create_admin_menus' ) );
		add_action( 'admin_init', array( $this, 'reveal_welcome' ), 11 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_some_admin_scripts' ) );
		// add_action( 'admin_head', array( $this, 'print_in_head' ) );
	}


	/**
	 * Add the screen id to the admin area
	 */
	public function print_in_head() {
		$screenid = $this->print_current_screen();

		echo '<pre><h4 style="text-align: center; color: salmon;">';
		echo '<p> ' . $screenid;
		echo '</h4></pre>;';
	}

	public function print_current_screen() {
		$screen = get_current_screen();
		return $screen->id;
	}
	/**
	 * Add the page to the admin area
	 */
	public function enqueue_some_admin_scripts() {
		wp_register_script( 'psa', plugins_url( 'js/psa.js', __FILE__ ), array( 'jquery' ), time() );
		wp_register_style( 'psa', plugins_url( 'css/psa.css', __FILE__ ), time() );
		wp_register_style( 'set-expiration', plugins_url( 'css/set-expiration.css', __FILE__ ), time() );
		if ( 'dashboard_page_pmpro-expiration-dates' === $this->print_current_screen() ) {
			wp_enqueue_script( 'psa' );
			wp_enqueue_style( 'psa' );
			wp_enqueue_style( 'set-expiration' );
		}
	}


	/**
	 * Add the page to the admin area
	 */
	public function create_admin_menus() {
		add_dashboard_page(
			'PMPro Expiration Dates Welcome',
			'PMPro Expiration Dates Welcome',
			self::min_caps,
			'pmpro-expiration-dates.php',
			array( $this, 'pmpro_expiration_welcome_message' )
		);

		// Remove the page from the menu
		remove_submenu_page( 'index.php', 'pmpro-expiration-dates.php' );
	}

	/**
	 * Add the page to the admin area
	 */
	public function to_the_customizer() {
		add_theme_page(
			'PMPro Expiration Dates Welcome',
			'PMPro Expiration Dates Welcome',
			self::min_caps,
			'customize.php'
			// array( $this, 'pmpro_expiration_welcome_message' )
		);

		// Remove the page from the menu
		// remove_submenu_page( 'index.php', 'pmpro-expiration-dates.php' );
	}

	/**
	 * Display the plugin welcome message
	 */
	public function pmpro_expiration_welcome_message() {
		?>
		<div class="wrap">

			<div class="wrapper">
				<div id="plugin-header" class="box header">
					<img src="https://www.paidmembershipspro.com/wp-content/uploads/2017/09/cropped-Paid-Memberships-Pro.png">
				</div>
				<div class="box sidebar"><h2>about the</h2><h1>Set Expiration Dates</h1> <h2>Plugin</h2></div>
				<div class="box logo">
					<img src="https://www.paidmembershipspro.com/wp-content/uploads/2013/06/Set-Expiration-300x300.png" width="150px">
				</div>
				<div class="box content">
					<p class="description">
						Using this plugin as is will add an additional field to the edit level and edit discount code pages allowing you to set a specific expiration date. So instead of “expire in 30 days” you can set the level to “expire on 2019-01-01”.
					</p>
				</div>
				<div class="box footer">
					<p class="flashing description">
						Please note: This plugin is not meant to be used with recurring subscriptions.
					</p>
					<p id="psa">This concludes this plugin's Public Service Announcement. Please enjoy responsibly.</p>
				</div>
			</div> <!-- .wrapper -->
		</div><!-- .wrapp -->
		<?php
	}

	/**
	 * Check the plugin activated transient exists if does then redirect
	 */
	public function reveal_welcome() {
		if ( ! get_transient( '_pmpro_expiration_dates' ) ) {
			return;
		}

		// Delete the plugin activated transient
		delete_transient( '_pmpro_expiration_dates' );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page' => 'pmpro-expiration-dates.php',
				), admin_url( 'index.php' )
			)
		);
		exit;
	}

	/**
	 *
	 */
	public function admin_head() {
		?>
		<style type="text/css">

		</style>
		<?php

		$current_screen = $this->print_current_screen();
		echo '<h4 style="position: absolute;z-index:3333;left: 64%;">Screen = ' . $current_screen . '</h4>';

		// Add custom styling to your page
		 // remove_submenu_page( 'index.php', 'welcome-screen-about' );
	}
}
