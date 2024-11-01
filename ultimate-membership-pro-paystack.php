<?php
/*
Plugin Name: Ultimate Membership Pro - Paystack
Plugin URI: https://store.wpindeed.com/
Description: With the help of this addon, you may grow your business, membership system, and collect payments from anywhere in the world.
Version: 1.3
Author: WPIndeed
Author URI: https://store.wpindeed.com

Text Domain: ultimate-membership-pro-paystack
Domain Path: /languages

@package         Ultimate Membership Pro AddOn - PayStack
@author           WPIndeed Development
*/


		include plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

		if ( !defined( 'UMP_PAYSTACK_PATH' ) ){
				define( 'UMP_PAYSTACK_PATH', plugin_dir_path( __FILE__ ) );
		}
		if ( !defined( 'UMP_PAYSTACK_URL' ) ){
				define( 'UMP_PAYSTACK_URL', plugin_dir_url( __FILE__ ) );
		}

		$UmpPayStackSettings = new \UmpPayStack\Settings();
		$UmpPayStackViewObject = new \UmpPayStack\View();

		\UmpPayStack\Utilities::setSettings( $UmpPayStackSettings->get() );
		\UmpPayStack\Utilities::setLang();
		if ( !\UmpPayStack\Utilities::canRun() ){
				return;
		}

		if ( is_admin() ){
				$UmpPayStackAdmin = new \UmpPayStack\Admin\Main( $UmpPayStackSettings->get(), $UmpPayStackViewObject );
		}
		$UmpPayStack = new \UmpPayStack\Main( $UmpPayStackSettings->get(), $UmpPayStackViewObject );
