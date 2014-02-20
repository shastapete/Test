<?php




/* INCLUDE SCRIPTS */


function up546E_bps_scripts() {
	wp_enqueue_style( 'bps_button_style', plugins_url( '/css/bps_buttonstyle.css' , __FILE__ ) );
	wp_enqueue_style( 'bps_manage_subs_page_stlye', plugins_url( '/css/bps_manage_subs_page_style.css' , __FILE__ ) );
	wp_enqueue_style( 'bps_whats_new_page_stlye', plugins_url( '/css/bps_whats_new_page_style.css' , __FILE__ ) );


	wp_register_script( "bps_button_script", plugins_url( '/js/bps_button.js' , __FILE__ ), array('jquery') );
	wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );       
	wp_enqueue_script( 'bps_button_script' );
}

add_action( 'wp_enqueue_scripts', 'up546E_bps_scripts' );

// INCLUDE SUB FILES 

function up546E_bps_include_files() {
	include dirname(__FILE__).'/includes/bps_subscribe_button.php';
	include dirname(__FILE__).'/includes/bps_query_functions.php';
	include dirname(__FILE__).'/includes/bps_subscription_handler.php';
	include dirname(__FILE__).'/includes/bps_revision_postmeta.php';
	include dirname(__FILE__).'/includes/bps_functions.php';
}

add_action( 'init', 'up546E_bps_include_files');

global $bpsubscriptions_db_version;
$bpsubscriptions_db_version = "1.0";
	
function up546E_bps_install_db() {
   global $wpdb;
   global $bpsubscriptions_db_version;

   $table_name = $wpdb->base_prefix . "bps_post_subscriptions";
	  
   $sql = "CREATE TABLE $table_name (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  post_id bigint(20) NOT NULL,
  user_id bigint(20) NOT NULL,
  blog_id bigint(20) NOT NULL,
  UNIQUE KEY id (id)
	);";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("bpsubscriptions_db_version", $bpsubscriptions_db_version);
}

register_activation_hook(__FILE__,'up546E_bps_install_db');


// ADD MENU ITEMS TO BUDDY PRESS

function up546E_bps_add_nav_items() {
	global $bp;
	bp_core_new_nav_item( 
		array( 
			'name' => __('Subscriptions', 'buddypress'), 
			'slug' => 'subscriptions', 
			'position' => 60, 
			'show_for_displayed_user' => false, 
			'screen_function' => 'up546E_bps_menu_subscription', 
			'default_subnav_slug' => 'whats-new', 
		));
		
	bp_core_new_subnav_item( array( 
        'name' => __('What\'s New', 'buddypress'),
        'slug' => 'whats-new',
        'parent_url' => $bp->loggedin_user->domain . 'subscriptions/',
        'parent_slug' => 'subscriptions',
        'screen_function' => 'up546E_bps_menu_subscription_whatsnew',
        'position' => 10
    ) );
    
    bp_core_new_subnav_item( array( 
        'name' => __('Manage Subscriptions', 'buddypress'),
        'slug' => 'manage-subs',
        'parent_url' => $bp->loggedin_user->domain . 'subscriptions/',
        'parent_slug' => 'subscriptions',
        'screen_function' => 'up546E_bps_menu_subscription_mansubs',
        'position' => 20
    ) );
}

add_action( 'bp_setup_nav','up546E_bps_add_nav_items');


function up546E_bps_menu_subscription_whatsnew() {

	add_action( 'bp_template_content', 'up546E_bps_menu_subscription_whatsnew_show' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function up546E_bps_menu_subscription_whatsnew_show() {
	include dirname(__FILE__).'/includes/bps_whats_new_page.php';

}

function up546E_bps_menu_subscription_mansubs() {

	add_action( 'bp_template_content', 'up546E_bps_menu_subscription_mansubs_show' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function up546E_bps_menu_subscription_mansubs_show() {
	include dirname(__FILE__).'/includes/bps_manage_subs_page.php';
}


?>