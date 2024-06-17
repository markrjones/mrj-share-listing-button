<?php
   /*
   Plugin Name: Share Listings Button
   Plugin URI: 
   description: Adds a share button to those shown alongside a listing in the dashboard
   Version: 0.2
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



// All below here deals with the settings menu
add_action( 'admin_menu', 'mrjslb_create_menu' );
function mrjslb_create_menu() {
             
    //create custom top-level menu
    add_menu_page( 'Quickbook', 'Quickbook Settings',
        'manage_options', 'mrjslb-options', 'mrjslb_settings_page',
        'dashicons-text-page', 99 );
            
}

add_action( 'admin_init', 'remove_listeo_mini_booking_admin_menu' );
function remove_listeo_mini_booking_admin_menu() {
    remove_menu_page('listeo_payouts');
}

// 

add_action('admin_init', 'mrjslb_plugin_admin_init');
function mrjslb_plugin_admin_init(){

	// Define the setting args
	$args = array(
	    'type' 				=> 'string', 
	    'sanitize_callback' => 'mrjslb_plugin_validate_options',
	    'default' 			=> NULL
	);

    // Register our settings
    register_setting( 'mrjslb_plugin_options', 'mrjslb_plugin_options', $args );
    
    // Add a settings section
    add_settings_section( 
    	'mrjslb_plugin_main', 
    	'Quickbook Form Settings',
        'mrjslb_plugin_section_text', 
        'mrjslb_plugin' 
    );
    
    // Create our settings field for page name
    add_settings_field( 
    	'mrjslb_plugin_page_name', 
    	'Page Name',
        'mrjslb_plugin_setting_page_name', 
        'mrjslb_plugin', 
        'mrjslb_plugin_main' 
    );

}

// Draw the section header
function mrjslb_plugin_section_text() {
    echo '<p>Settings to control the page name assigned the quickbook shortcode.</p>';
}
        
// Display and fill the Page Name text form field
function mrjslb_plugin_setting_page_name() {

    // Get option 'text_string' value from the database
    $options = get_option( 'mrjslb_plugin_options', array( "page_name" => "quickbook" ));
    $page_name = $options['page_name'];

    // Echo the field
    echo "<input id='page_name' name='mrjslb_plugin_options[page_name]'
        type='text' value='" . esc_attr( $page_name ) . "' />";
}

// Validate user input for page name
function mrjslb_plugin_validate_options( $input ) {

	// Only allow letters and spaces for the page name
    $valid['page_name'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['page_name'] );
        
    if( $valid['page_name'] !== $input['page_name'] ) {

        add_settings_error(
            'mrjslb_plugin_text_string',
            'mrjslb_plugin_texterror',
            'Incorrect value entered! Please only input letters and spaces.',
            'error'
        );

    }
        
    // Sanitize the data we are receiving 
    $valid['page_name'] = sanitize_text_field( $input['page_name'] );

    return $valid;
}

// Placeholder function for the settings page
function mrjslb_settings_page() {
    ?>
    <div class="wrap">
        <form action="options.php" method="post">
        <?php 
            settings_fields( 'mrjslb_plugin_options' );
    	    do_settings_sections( 'mrjslb_plugin' );
		    submit_button( 'Save Changes', 'primary' ); 
        ?>
        </form>
    </div>
    <?php
}

?>
