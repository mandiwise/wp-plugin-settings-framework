<?php
/**
 * Plugin Name: YOUR PLUGIN
 * Description: This isn't actually a plugin, it's just to show you how to include the settings in your plugin.
 *
 */

class Your_Plugin_Class {

	/**
    * Constructor
    */

	function __construct() {

		// Other constructor things for your plugin happen here...

		// Require the settings and initiate the plugin settings class
		require_once( sprintf( "%s/admin/class-plugin-settings.php", dirname( __FILE__ ) ) );
		$PLUGIN_NAME_Settings = new PLUGIN_NAME_Settings(); // "PLUGIN_NAME" is the class name set in class-plugin-settings.php

	} // end constructor


   /**
    * The Rest of the Plugin...
    */

	public function plugin_stuff() {

		// Grab one of your options and use them in your plugin
		$example_text = PREFIX_option( 'example_text' ); // "PREFIX" is the prefix you set in class-plugin-settings.php

		echo 'This is some awesome ' . $example_text . ' I saved in the text input field of my plugin.';

	}

} // end Your_Plugin_Class

$your_plugin_class = new Your_Plugin_Class();
