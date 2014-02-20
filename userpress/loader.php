<?php
/*

 * Plugin Name: UserPress
 * Plugin URI:  http://userpress.org
 * Description: UserPress Suite adds wiki functionality to your WordPress site along with other features (automatic table of contents, revision notes, content moderation, and more.)
 * Author:      UserPress
 * Author URI:  http://userpress.org
 * Version:     1.1.3
 
 */
 
include dirname(__FILE__) . '/query-filter/qfilter.php';
include dirname(__FILE__) . '/enhanced-404/e404.php';
include dirname(__FILE__) . '/wiki/wiki.php';
include dirname(__FILE__) . '/toc/toc.php';
include dirname(__FILE__) . '/revisions/custom-field-revisions.php';
include dirname(__FILE__) . '/post-favorites/post-favorites.php';
include dirname(__FILE__) . '/comments-query/comments-query.php';
include dirname(__FILE__) . '/buddypresssubscriptions/bps.php';
include dirname(__FILE__) . '/print-view/pv.php';




// ADD DEFAULT WIKI PAGE UPON INSTALL 
register_activation_hook( __FILE__, 'up546E_insert_default_page');

function up546E_insert_default_page()
  {
   //post status and options
    $post = array(
          'post_author' => 1,
          'post_name' => 'frontpage',
          'post_content' => 'This is your first wiki page. You should edit it.',          
          'post_status' => 'publish' ,
          'post_title' => 'Frontpage',
          'post_type' => 'userpress_wiki',
    );  
 
 
     $page_exists = get_page_by_path( 'frontpage', $output, 'userpress_wiki' );

    if( $page_exists == null ) {
        // Page doesn't exist, so lets add it
        
 //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database

    } 
 
}

// END DEFAULT PAGE 


/* hook updater to init */
add_action( 'init', 'up546E_UserPress_Updater_init' );

/**
 * Load and Activate Plugin Updater Class.
 */
function up546E_UserPress_Updater_init() {

    /* Load Plugin Updater */
    require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

    /* Updater Config */
    $config = array(
        'base'      => plugin_basename( __FILE__ ), //required
        'dashboard' => false,
        'username'  => false,
        'key'       => '',
        'repo_uri'  => 'http://userpress.kabooru.com/',
        'repo_slug' => 'userpress',
    );

    /* Load Updater Class */
    new up546E_UserPress_Updater( $config );
}
  
?>