<?php
/**
 * Plugin Name: Hello World.
 * Description: Test project.
 * Version: 1.0.0
 * Text Domain: hello-world
 * Author: Rustam
 * Domain Path: /languages/
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Register extension directory.
add_filter(
	'hivepress/v1/extensions',
	function( $extensions ) {
		$extensions[] = __DIR__;

		return $extensions;
	}
);