<?php
   /*
   Plugin Name: Share Listings Button
   Plugin URI: 
   description: Adds a share button to those shown alongside a listing in the dashboard
   Version: 0.1
   Author: Mark Jones
   Author URI: https://devlisteo.ownersclub.eu
   */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Used by the template loader
define( 'MRJ_SHARE_LISTING_BUTTON_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
//$thisplugin = plugin_dir_path( __FILE__ );

function mrj_enqueue_scripts() {
    wp_register_script( 'mrj-share-button', plugin_dir_url(__FILE__) . 'assets/js/mrj-share-button.js', array( 'jquery' ), '1.0' );
    wp_enqueue_script('mrj-share-button');
}
add_action( 'wp_enqueue_scripts', 'mrj_enqueue_scripts', 999 );

include( 'includes/mrj-share-listing-button-class-template-loader.php');
include( 'includes/mrj-share-listing-button-class-listeo-core-users.php' );
$my_users = new Mrj_Share_Listing_Button_Listeo_Core_Users();

?>
