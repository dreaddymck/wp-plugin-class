<?php
/*
Plugin Name: (DMCK) starter plugin
Plugin URI: dreaddymck.com
Description: Another Wordpress starter plugin. There are many starter plugins out there. This is mine. shortcode = [dmck-starter-plugin]
Version: 1.0
Author: dreaddymck
Author URI: dreaddymck.com
License: MIT
*/

// error_reporting(E_ALL);
// ini_set("display_errors","On");

if (!class_exists("DMCK_starter_plugin_cls")) {

	class DMCK_starter_plugin_cls {

		public $plugin_title 			= '(DMCK) starter plugin';
		public $plugin_slug				= 'dmck_starter_plugin';
		public $plugin_settings_group 	= 'dmck-starter-plugin-settings-group';
		public $shortcode				= "dmck-starter-plugin";	
			
		public $adminpreferences 		= array('adminpreferences','favicon');
		public $userpreferences 		= array('userpreferences');

		public $plugin_url;
		public $plugin_dir_path;
		public $theme_url;
		public $github_url				= "";
				
		public $wpdb;		

		function __construct() {
			
			global $wpdb;
			
			$this->wpdb 			= $wpdb;
			$this->plugin_url 		= plugins_url("/",__FILE__);
			$this->theme_url		= dirname( get_bloginfo('stylesheet_url') );	
			$this->plugin_dir_path	= plugin_dir_path(__FILE__);

			register_activation_hook( __FILE__, array($this, 'register_activation' ) );		

			add_action( 'init', array( $this, 'register_shortcodes'));
			add_action( 'admin_init', array( $this, 'register_settings') );
			add_action( 'admin_menu', array( $this, 'admin_menu' ));
			add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_setup'), 999);
			add_action( 'wp_enqueue_scripts', array($this, 'user_scripts') );
			
			add_action( 'wp_head', array($this, 'head_hook') );
			add_action( 'login_head', array($this, 'head_hook') );
			add_action( 'admin_head', array($this, 'head_hook') );			
		}

		function register_activation($options){}
		function register_shortcodes(){
			add_shortcode( $this->shortcode, array( $this, 'include_file') );
		}
		function register_settings() {
			foreach($this->adminpreferences as $settings ) {
				register_setting( $this->plugin_settings_group, $settings );
			}
			foreach($this->userpreferences as $settings ){
				register_setting( $this->plugin_settings_group, $settings );
			}
		}

		function admin_menu()
		{
			$this->settings_page = add_options_page(
					$this->plugin_title,
					$this->plugin_title,
					'read',
					$this->plugin_slug,
					array( $this, 'admin_menu_include') 
			);
		}
		function admin_scripts($hook_suffix) {
			
			if ( $this->settings_page == $hook_suffix ) {
				
				$this->shared_scripts();
				wp_enqueue_style( 'admin.css',  $this->plugin_url . "/admin.css");
				wp_enqueue_script( 'admin.js', $this->plugin_url . '/admin.js', array( 'jquery' ), '1.0.1', true );
				$this->localize_vars();
			}

		}
		function user_scripts() {
			
			if( $this->has_shortcode( $this->shortcode ) ) {}			

			$this->shared_scripts();
			$this->localize_vars();

		}
		function shared_scripts(){
			wp_enqueue_style( 'style.css',  $this->plugin_url . "/style.css");
			wp_enqueue_script( 'functions.js', $this->plugin_url . '/js/functions.js', array( 'jquery' ), '1.0.1', true );
		}
		function localize_vars(){
			$local = array(
					'plugin_url' => $this->plugin_url,
					'is_front_page' => is_front_page(),
					'is_single' => is_single(),
					'is_page' => is_page(),
					'plugin_slug' => $this->plugin_slug,
					'plugin_title' => $this->plugin_title,
					'github_url' => $this->github_url,
					'has_shortcode' => $this->has_shortcode($this->shortcode),
			);
		
			wp_localize_script( 'functions.js', $this->plugin_slug, $local);
		}		
		function has_shortcode($shortcode = '') {
		
			$post_to_check = get_post(get_the_ID());
			$found = false;
		
			if ($shortcode && $post_to_check) {
				if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {
					$found = true;	
				}
			}
			return $found;
		}		
		function admin_bar_setup(){

			global $wp_admin_bar;

			if ( !is_super_admin() || !is_admin_bar_showing() ) return;

			$url_to = admin_url( 'options-general.php?page='.$this->plugin_slug);
			
			$wp_admin_bar->add_menu( 
									array( 
											'id' => $this->plugin_slug,
											'title' => __( $this->plugin_title, $this->plugin_slug ),
											'href' => $url_to, 
											'meta'  => array( 
															'title' => $this->plugin_title, 
															'class' => $this->plugin_slug 
															)
											
										)
									);
		}
		function include_file($options) {
			//include (plugin_dir_path(__FILE__).'file.php');
			echo "<h1>Content</h1>";
		}

		function admin_menu_include() {
			if ( !current_user_can( 'read' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			include ( plugin_dir_path(__FILE__).'admin.php' );
			
		}
		function head_hook() {
			$favicon = esc_attr( get_option('favicon') );
			if( $favicon ){
				echo  '<link href="'.$favicon.'" rel="icon" type="image/x-icon"></link>';
			}
		}			
		function var_error_log( $object=null ){
			ob_start();                    // start buffer capture
			var_dump( $object );           // dump the values
			$contents = ob_get_contents(); // put the buffer into a variable
			ob_end_clean();                // end capture
			error_log( $contents );        // log contents of the result of var_dump( $object )
		}


	}
	new DMCK_starter_plugin_cls();
}

?>
