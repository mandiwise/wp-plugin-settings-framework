<?php
/*
Plugin Name: YOUR PLUGIN
Description: This isn't actually a plugin, it's just to show you how to include the settings in your plugin.

*/

class YourPluginClass {

	// * Constructor *
		
	// - Add the settings page to your plugin's constructor function -
	function __construct() {

		// - other constructor things for your plugin happen here... -

		// - require the settings and initiate the plugin settings class -
		require_once( sprintf( "%s/views/admin.php", dirname( __FILE__ ) ) );
		$PLUGIN_NAME_Settings = new PLUGIN_NAME_Settings(); // - replace PLUGIN_NAME with the class name set in admin.php -

	} // - end constructor -
	
	
	// * The Rest of the Plugin... *
	public function plugin_stuff() {
	
		// - grab your options and use them in your plugin -
		$example_text = PREFIX_option( 'example_text' ); // - "PREFIX" would be the prefix you set in the admin.php file -
	
		echo 'This is some awesome ' . $example_text . ' I saved in the text input field of my plugin.';
	
	}
	
} // - end class -

$your_plugin_class = new YourPluginClass();