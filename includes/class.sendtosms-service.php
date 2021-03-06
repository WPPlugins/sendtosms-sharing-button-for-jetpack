<?php

if( !function_exists('add_action') ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if( did_action('jetpack_modules_loaded') ) {
	jetsms_Sharing_Service::init();
} else {
	add_action( 'jetpack_modules_loaded', array( 'jetsms_Sharing_Service', 'init' ) );
}

class jetsms_Sharing_Service {
	static $instance;

	static function init() {
		if( !Jetpack::is_module_active('sharedaddy') ) {
			return false;
		}

		if( !self::$instance ) {
			self::$instance = new jetsms_Sharing_Service;
		}

		return self::$instance;
	}

	function __construct() {
		add_filter( 'sharing_services', array( &$this, 'add_sharing_services' ) );
	}

	function add_sharing_services( $services ) {
		include_once jetsms__PLUGIN_DIR . 'includes/class.sendtosms-source.php';

		if( !array_key_exists( 'sendtosms', $services ) ) {
			$services['sendtosms'] = 'jetsms_Share_sendtosms';
		}

		return $services;
	}
}
