<?php
/**
 * Plugin Name: Ghostdar
 */

use Ghostdar\Framework\Abstracts\Container;
use Ghostdar\Framework\Abstracts\ServiceProvider;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Ghostdar {
	/**
	 * @since 2.8.0
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * @var array Array of Service Providers to load
	 */
	private $serviceProviders = [
		Ghostdar\Assets\ServiceProvider::class,
		Ghostdar\Ghosts\ServiceProvider::class,
		Ghostdar\Sightings\ServiceProvider::class,
		Ghostdar\Framework\Migrations\ServiceProvider::class,
	];

	/**
	 * @var bool Make sure the providers are loaded only once
	 */
	private $providersLoaded = false;

	/**
	 * Ghostdar constructor.
	 *
	 * Sets up the Container to be used for managing all other instances and data
	 *
	 */
	public function __construct() {
		$this->container = new Container();
	}

	/**
	 * Bootstraps the Ghostdar Plugin
	 *
	 * @since 2.8.0
	 */
	public function boot() {
		// PHP version
		if ( ! defined( 'GHOSTDAR_REQUIRED_PHP_VERSION' ) ) {
			define( 'GHOSTDAR_REQUIRED_PHP_VERSION', '5.6.0' );
		}

		// Bailout: Need minimum php version to load plugin.
		if ( function_exists( 'phpversion' ) && version_compare( GHOSTDAR_REQUIRED_PHP_VERSION, phpversion(), '>' ) ) {
			add_action( 'admin_notices', [ $this, 'minimumPhpversionNotice' ] );

			return;
		}

		$this->setupConstants();

		add_action( 'plugins_loaded', [ $this, 'init' ], 0 );

		register_activation_hook( GHOSTDAR_PLUGIN_FILE, [ $this, 'install' ] );

		do_action( 'ghostdar_loaded' );
	}

	/**
	 * Init Ghostdar when WordPress Initializes.
	 *
	 * @since 1.8.9
	 */
	public function init() {
		/**
		 * Fires before the Ghostdar core is initialized.
		 *
		 * @since 1.8.9
		 */
		do_action( 'before_ghostdar_init' );

		// Set up localization.
		$this->loadTextdomain();

		$this->bindClasses();

		$this->loadServiceProviders();

		do_action( 'ghostdar_init', $this );
	}

	/**
	 * Binds the initial classes to the service provider.
	 */
	private function bindClasses() {
		//$this->container->singleton( 'templates', Templates::class );
	}

	/**
	 * Setup plugin constants
	 * @return void
	 */
	private function setupConstants() {
		// Plugin version.
		if ( ! defined( 'GHOSTDAR_VERSION' ) ) {
			define( 'GHOSTDAR_VERSION', '0.0.1' );
		}

		// Plugin Root File.
		if ( ! defined( 'GHOSTDAR_PLUGIN_FILE' ) ) {
			define( 'GHOSTDAR_PLUGIN_FILE', __FILE__ );
		}

		// Plugin Folder Path.
		if ( ! defined( 'GHOSTDAR_PLUGIN_DIR' ) ) {
			define( 'GHOSTDAR_PLUGIN_DIR', plugin_dir_path( GHOSTDAR_PLUGIN_FILE ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'GHOSTDAR_PLUGIN_URL' ) ) {
			define( 'GHOSTDAR_PLUGIN_URL', plugin_dir_url( GHOSTDAR_PLUGIN_FILE ) );
		}

		// Plugin Basename aka: "ghostdar/index.php".
		if ( ! defined( 'GHOSTDAR_PLUGIN_BASENAME' ) ) {
			define( 'GHOSTDAR_PLUGIN_BASENAME', plugin_basename( GHOSTDAR_PLUGIN_FILE ) );
		}

		// Make sure CAL_GREGORIAN is defined.
		if ( ! defined( 'CAL_GREGORIAN' ) ) {
			define( 'CAL_GREGORIAN', 1 );
		}
	}

	/**
	 * Loads the plugin language files.
	 */
	public function loadTextdomain() {
		// Set filter for Ghostdar's languages directory
		$lang_dir = dirname( plugin_basename( GHOSTDAR_PLUGIN_FILE ) ) . '/languages/';
		$lang_dir = apply_filters( 'left_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter.
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'ghostdar' );

		unload_textdomain( 'ghostdar' );
		load_textdomain( 'ghostdar', WP_LANG_DIR . '/ghostdar/ghostdar-' . $locale . '.mo' );
		load_plugin_textdomain( 'ghostdar', false, $lang_dir );
	}


	/**
	 *  Show minimum PHP version notice.
	 */
	public function minimumPhpversionNotice() {
		// Bailout.
		if ( ! is_admin() ) {
			return;
		}

		$notice_desc  = '<p><strong>' . __(
			'Your site could be faster and more secure with a newer PHP version.',
			'ghostdar'
		) . '</strong></p>';
		$notice_desc .= '<p>' . __(
			'Hey, we\'ve noticed that you\'re running an outdated version of PHP. PHP is the programming language that WordPress and Ghostdar are built on. The version that is currently used for your site is no longer supported. Newer versions of PHP are both faster and more secure. In fact, your version of PHP no longer receives security updates, which is why we\'re sending you this notice.',
			'ghostdar'
		) . '</p>';
		$notice_desc .= '<p>' . __(
			'Hosts have the ability to update your PHP version, but sometimes they don\'t dare to do that because they\'re afraid they\'ll break your site.',
			'ghostdar'
		) . '</p>';
		$notice_desc .= '<p><strong>' . __( 'To which version should I update?', 'give' ) . '</strong></p>';
		$notice_desc .= '<p>' . __(
			'You should update your PHP version to either 5.6 or to 7.0 or 7.1. On a normal WordPress site, switching to PHP 5.6 should never cause issues. We would however actually recommend you switch to PHP7. There are some plugins that are not ready for PHP7 though, so do some testing first. PHP7 is much faster than PHP 5.6. It\'s also the only PHP version still in active development and therefore the better option for your site in the long run.',
			'ghostdar'
		) . '</p>';
		$notice_desc .= '<p><strong>' . __( 'Can\'t update? Ask your host!', 'give' ) . '</strong></p>';
		$notice_desc .= '<p>' . sprintf(
			__(
				'If you cannot upgrade your PHP version yourself, you can send an email to your host. If they don\'t want to upgrade your PHP version, we would suggest you switch hosts. Have a look at one of the recommended %1$sWordPress hosting partners%2$s.',
				'ghostdar'
			),
			sprintf(
				'<a href="%1$s" target="_blank">',
				esc_url( 'https://wordpress.org/hosting/' )
			),
			'</a>'
		) . '</p>';

		echo sprintf(
			'<div class="notice notice-error">%1$s</div>',
			wp_kses_post( $notice_desc )
		);
	}

	public function install() {
		$this->loadServiceProviders();
		// Handle install
		do_action('ghostdar_upgrades');
	}

	/**
	 * Load all the service providers to bootstrap the various parts of the application.
	 */
	private function loadServiceProviders() {
		if ( $this->providersLoaded ) {
			return;
		}

		$providers = [];

		foreach ( $this->serviceProviders as $serviceProvider ) {
			if ( ! is_subclass_of( $serviceProvider, ServiceProvider::class ) ) {
				throw new InvalidArgumentException( "$serviceProvider class must implement the ServiceProvider interface" );
			}

			/** @var ServiceProvider $serviceProvider */
			$serviceProvider = new $serviceProvider();

			$serviceProvider->register();

			$providers[] = $serviceProvider;
		}

		foreach ( $providers as $serviceProvider ) {
			$serviceProvider->boot();
		}

		$this->providersLoaded = true;
	}

	/**
	 * Register a Service Provider for bootstrapping
	 */
	public function registerServiceProvider( $serviceProvider ) {
		$this->serviceProviders[] = $serviceProvider;
	}

	/**
	 * Magic properties are passed to the service container to retrieve the data.
	 *
	 * @param string $propertyName
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function __get( $propertyName ) {
		return $this->container->get( $propertyName );
	}

	/**
	 * Magic methods are passed to the service container.
	 *
	 * @since 2.8.0
	 *
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed
	 */
	public function __call( $name, $arguments ) {
		return call_user_func_array( [ $this->container, $name ], $arguments );
	}
}

/**
 * Start Ghostdar
 *
 * The main function responsible for returning the one true Ghostdar instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $ghostdar = Ghostdar(); ?>
 *
 * @param null $abstract Selector for data to retrieve from the service container
 *
 * @return object|Ghostdar
 */
function Ghostdar( $abstract = null ) {
	static $instance = null;

	if ( $instance === null ) {
		$instance = new Ghostdar();
	}

	if ( $abstract !== null ) {
		return $instance->make( $abstract );
	}

	return $instance;
}

require 'vendor/autoload.php';

Ghostdar()->boot();
