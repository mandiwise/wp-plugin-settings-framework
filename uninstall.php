<?php

/*
 * This sample uninstall.php file demonstrates how to clean up after your settings
 * when a user deletes your plugin from WordPress.
 *
 * INSTRUCTIONS:
 *
 * Find and replace "PREFIX" with the prefix you used in class-plugin-settings.php
 *
 */

/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove the expiration rule settings.
if ( is_multisite() ) {
	global $wpdb;
	$blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );
	delete_option( 'PREFIX_options' );

	if ( $blogs ) {
		foreach( $blogs as $blog ) {
			switch_to_blog( $blog['blog_id'] );
			delete_option( 'PREFIX_options' );
		}
	}

} else {
	delete_option( 'PREFIX_options' );
}
