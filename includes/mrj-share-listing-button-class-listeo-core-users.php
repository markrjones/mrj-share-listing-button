<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * Listeo_Core_User class
 */
class Mrj_Share_Listing_Button_Listeo_Core_Users extends Listeo_Core_Users {

	/**
	* Dashboard message.
	*
	* @access private
	* @var string
	*/
	private $dashboard_message = '';
	
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'listeo_my_listings', array( $this, 'mrj_listeo_core_my_listings' ) );
		
	}

	/**
	 * User listings shortcode
	 */
	public function mrj_listeo_core_my_listings( $atts ) {
		if ( ! is_user_logged_in() ) {
			return __( 'You need to be signed in to manage your listings.', 'listeo_core' );
		}

		
		$page = (isset($_GET['listings_paged'])) ? $_GET['listings_paged'] : 1;
		
		if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		} else {
			$status = '';
		}
		ob_start();
		$mrj_template_loader = new Mrj_Share_Listing_Button_Template_Loader;
		
		$status = isset($_GET['status']) ? $_GET['status'] : '' ;
		$search = isset($_GET['search']) ? $_GET['search'] : '' ;
		
		$mrj_template_loader->set_template_data( 
			array( 
				'message' => $this->dashboard_message, 
				'ids' => $this->get_agent_listings($status,$page,10,$search),
				'status' => $status, 
			) )->get_template_part( 'account/my-listings' ); 


		return ob_get_clean();
	}	

}