<?php 
    /**
	 * Plugin Name: Awesome Product Menu for Woocommerce
	 * Description: When adding a WooCommerce category in your header menu, this plugin allows you to show a dropdown of the products you have listed inside.
	 * Author: 7South Digital
	 * Version: 1.0 
	 * Text Domain: awesome-product-menu-for-woocommerce
	 * Author URI: www.7south.digital
	 */
	defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if(! class_exists('awesome_product_menu_fw')):
        final class awesome_product_menu_fw {
            protected $_version = '1.0.0';
			
			protected static $_instance = null;
            private          $_settings_api;

            public static function instance() {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self();
				}
				return self::$_instance;
            }
            public function __construct() {
				$this->constants();
				$this->includes();
				$this->hooks();
            }
            
            public function constants(){
				$this->define( 'AMP_PLUGIN_INCLUDE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
				$this->define( 'AMP_PLUGIN_TEMPLATES_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'templates' ) );
				$this->define( 'AMP_PLUGIN_TEMPLATES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'templates' ) );
				$this->define( 'AMP_PLUGIN_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

				$this->define( 'AMP_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
				$this->define( 'AMP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
				$this->define( 'AMP_PLUGIN_FILE', __FILE__ );
				$this->define( 'AMP_IMAGES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'images' ) );
				$this->define( 'AMP_ASSETS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
            }

            public function hooks(){
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts'), 10);
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );	
            }

            public function includes(){
				if( $this->is_required_php_version() ){
					require_once $this->include_path( 'functions.php' );
					require_once $this->include_path( 'hooks.php' );
				}
            }
            
            public function define( $name, $value, $case_insensitive = false ) {
				if ( ! defined( $name ) ) {
					define( $name, $value, $case_insensitive );
				}
			}
			
			public function include_path( $file ) {
				$file = ltrim( $file, '/' );				
				return AMP_PLUGIN_INCLUDE_PATH . $file;
            }
            
			public function enqueue_scripts(){
				wp_enqueue_style('awesome-product-menu-fw-style', $this->assets_uri( "/css/style.css" ), array(), $this->version() );
				wp_enqueue_script('awesome-product-menu-fw-jquery', $this->assets_uri( "/js/init.js" ), array( 'jquery' ), $this->version(), true );
            }

            public function admin_enqueue_scripts(){
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style('awesome-menu-admin', $this->assets_uri( "/js/admin.js" ), array('jquery','wp-color-picker'), $this->version() );
            }
            public function assets_uri( $file ) {
				$file = ltrim( $file, '/' );
				
				return AMP_ASSETS_URI . $file;
            }
            
			public function basename() {
				return AMP_PLUGIN_BASENAME;
			}
			
			public function dirname() {
				return AMP_PLUGIN_DIRNAME;
			}
			
			public function version() {
				return esc_attr( $this->_version );
			}
			
			public function plugin_path() {
				return untrailingslashit( plugin_dir_path( __FILE__ ) );
			}
			
			public function plugin_uri() {
				return untrailingslashit( plugins_url( '/', __FILE__ ) );
			}
			public function is_required_php_version() {
				return version_compare( PHP_VERSION, '5.6.0', '>=' );
			}
			public function plugin_activated(){
				
			}
			public function plugin_deactivated(){
				wp_clear_scheduled_hook( 'amp_cron_stock' );
            }
        }
        function awesome_product_menu_fw() {
            return awesome_product_menu_fw::instance();
        }

        add_action( 'plugins_loaded', 'awesome_product_menu_fw', 10 );
        register_activation_hook( __FILE__, array( 'awesome_product_menu_fw', 'plugin_activated' ) );
        register_deactivation_hook( __FILE__, array( 'awesome_product_menu_fw', 'plugin_deactivated' ) );
        
    endif;