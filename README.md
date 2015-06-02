# wp-plugin-class
starter class for wordpress plugin

instructions. 

Have fun. Fork. Share.

rename the values for to suite your needs

		public $plugin_title 			= '(DMCK) starter plugin';
		public $plugin_slug				= 'dmck_starter_plugin';
		public $plugin_settings_group 	= 'dmck-starter_plugin-settings-group';
		public $shortcode				= "dmck-starter_plugin";	
		
		
add content, includes to.

		function include_file($options) {
			//include (plugin_dir_path(__FILE__).'file.php');
			echo "<h1>Content</h1>";
		}

		function admin_menu_include() {
			if ( !current_user_can( 'read' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			//include ( plugin_dir_path(__FILE__).'admin.php' );			
			echo "<h1>Admin Stuff</h1>";
			
		}
		
		