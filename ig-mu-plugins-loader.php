<?php
/*
Plugin Name: iG:MU-Plugins Loader
Description: This is a plugin loader which scans all plugin folders in MU-PLUGINs directory and loads all plugin bootstrap files in those folders. For this to work, a plugin's bootstrap file should be named same as plugin folder name with a '.php' extension
Version: 1.0
Author: Amit Gupta
Author URI: http://igeek.info/
License: GNU GPL 2
*/

function ig_mu_plugins_loader() {
	if( ! defined( 'WPMU_PLUGIN_DIR' ) ) {
		return;
	}

	$mu_plugins_dirs = array_filter( scandir( WPMU_PLUGIN_DIR ) );

	$not_dir_key = array_search( '.', $mu_plugins_dirs );

	if( $not_dir_key !== false ) {
		unset( $mu_plugins_dirs[ $not_dir_key ] );
	}

	$not_dir_key = array_search( '..', $mu_plugins_dirs );

	if( $not_dir_key !== false ) {
		unset( $mu_plugins_dirs[ $not_dir_key ] );
	}

	unset( $not_dir_key );

	if( empty( $mu_plugins_dirs ) ) {
		return;
	}

	sort( $mu_plugins_dirs );

	foreach( $mu_plugins_dirs as $dir ) {
		$plugin_dir = trailingslashit( WPMU_PLUGIN_DIR ) . $dir;
		$plugin_file = trailingslashit( $plugin_dir ) . $dir . '.php';

		if( is_dir( $plugin_dir ) && file_exists( $plugin_file ) ) {
			require_once( $plugin_file );
		}

		unset( $plugin_file, $plugin_dir );
	}
}

ig_mu_plugins_loader();


//EOF
