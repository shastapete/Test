<?php

/**
 * Functions
 *
 * Core functionality and initial theme setup
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */

/**
 * Initiate UserTheme, for WordPress
 */




/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'up546E_usertheme_theme_setup' );

/**
 * Theme setup function.
 * @since  0.1.0
 */
function up546E_usertheme_theme_setup(){

	/* updater args */
	$updater_args = array(
		'repo_uri'    => 'http://userpress.kabooru.com/',
		'repo_slug'   => 'usertheme',
	);

	/* add support for updater */
	add_theme_support( 'auto-hosted-theme-updater', $updater_args );
}

/* Load Theme Updater */
require_once( trailingslashit( get_template_directory() ) . 'inc/theme-updater.php' );
new up546E_UserTheme_Updater;








// Disable BuddyPress bar
add_filter('show_admin_bar', '__return_false');

/**
 * Get the highest needed priority for a filter or action.
 *
 * If the highest existing priority for filter is already PHP_INT_MAX, this
 * function cannot return something higher.
 *
 * @param  string $filter
 * @return number|string
 */

// Repsonsive Wrapper for oembed video
add_filter('embed_oembed_html', 'up546E_my_embed_oembed_html', 99, 4);
function up546E_my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="flex-video widescreen">' . $html . '</div>';
}






/**

LOGIN FORM HACK
wp_login_form

Okay. So why are we doing all of this? 

WordPress offers a default login form function, but it has several problems. First, it doesn't contain a password recovery link. Secondly, if there is an error, it will send the user to the wp-login.php page as opposed to the page they were using to log in. Thirdly, if WordPress is hacked to send the user to the referring page upon an error, the default wp_login_form function has no way of display an error message.

I know this code looks convoluted, but I wanted to extend the functionality of the wp_login_form function while leaving its extensive features in tact so that others can make additional modifications.

As always, if you think that you can improve upon our code, please do so and share it with us. http://userpress.org



**/

add_action( 'login_form_top', 'up546E_add_error_message' );
function up546E_add_error_message() {
 if ($_GET['login'] == 'failed') echo "<p class='error'><strong>Error. Please try again<strong></p>" ;
}


add_action( 'login_form_middle', 'up546E_add_lost_password_link' );
function up546E_add_lost_password_link() {
    return '<p><a href="/wp-login.php?action=lostpassword">Lost Password?</a></p>';
}


add_action( 'wp_login_failed', 'up546E_my_front_end_login_fail' ); // hook failed login

function up546E_my_front_end_login_fail( $username ) {
$referrer = $_SERVER['HTTP_REFERER']; // where did the post submission come from?
// if there's a valid referrer, and it's not the default log-in screen
if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
if ( !strstr($referrer,'?login=failed') ) { // make sure we don't append twice
wp_redirect( $referrer . '?login=failed' ); // let's append some information (login=failed) to the URL for the theme to use
} else {
wp_redirect( $referrer );
}
exit;
}
}




function up546E_get_latest_priority( $filter )
{
    if ( empty ( $GLOBALS['wp_filter'][ $filter ] ) )
        return PHP_INT_MAX;

    $priorities = array_keys( $GLOBALS['wp_filter'][ $filter ] );
    $last       = end( $priorities );

    if ( is_numeric( $last ) )
        return PHP_INT_MAX;

    return "$last-z";
}


	// Featured Image Caption Functionality (by Andy Warren http://stackoverflow.com/a/13850898/1289267)
	function the_post_thumbnail_caption() {
	global $post;
	
	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
	
	if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}	

if ( ! function_exists( 'up546E_usertheme_setup' ) ) :

function up546E_usertheme_setup() {

	// Content Width
	if ( ! isset( $content_width ) ) $content_width = 900;

	// Language Translations
	load_theme_textdomain( 'foundation', get_template_directory() . '/languages' );

	// Custom Editor Style Support
	add_editor_style();

	// Support for Featured Images
	add_theme_support( 'post-thumbnails' ); 
	add_image_size( 'featured-image', 755, 425, true ); // custom size
	add_image_size( 'featured-thumbnail', 125, 70, true ); // custom size

	// Automatic Feed Links & Post Formats
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

}

add_action( 'after_setup_theme', 'up546E_usertheme_setup' );

endif;

/**
 * Enqueue Scripts and Styles for Front-End
 */

if ( ! function_exists( 'up546E_usertheme_assets' ) ) :

function up546E_usertheme_assets() {

	if (!is_admin()) {


 		wp_deregister_style( 'userpress_foundation_css' );

 		wp_deregister_style( 'userpress_normalize_css' );

 		wp_deregister_style( 'userpress_foundation_icons' );

		
		wp_enqueue_script( 'slimscroll', get_template_directory_uri().'/js/jquery.slimscroll.min.js', true, '1.3');
		

		if ( is_singular() ) wp_enqueue_script( "comment-reply" );

		// Load Stylesheets
		wp_enqueue_style( 'normalize', get_template_directory_uri().'/css/normalize.css' );
		wp_enqueue_style( 'foundation', get_template_directory_uri().'/css/foundation.min.css' );
		wp_enqueue_style( 'icons', get_template_directory_uri().'/icons/foundation-icons.css' );
		wp_enqueue_style( 'app', get_stylesheet_uri(), array('foundation') );

		// Load Google Fonts API
		wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300' );
	
	}

}

add_action( 'wp_enqueue_scripts', 'up546E_usertheme_assets' );

endif;




/**
* Register Navigation Menus
*/

if ( ! function_exists( 'up546E_foundation_menus' ) ) :

// Register wp_nav_menus
function up546E_foundation_menus() {

        register_nav_menus(
                array(
                        'header-menu' => __( 'Header Menu', 'usertheme' )
                )
        );
        
}

add_action( 'init', 'up546E_foundation_menus' );

endif;

if ( ! function_exists( 'up546E_foundation_page_menu' ) ) :

function up546E_foundation_page_menu() {

        $args = array(
        'sort_column' => 'menu_order, post_title',
        'menu_class' => 'large-12 columns',
        'include' => '',
        'exclude' => '',
        'echo' => true,
        'show_home' => false,
        'link_before' => '',
        'link_after' => ''
        );

        wp_page_menu($args);

}

endif;

/**
* Navigation Menu Adjustments
*/

// Add class to navigation sub-menu
/*class foundation_navigation extends Walker_Nav_Menu {

function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown\">\n";
}

function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) ) {
                $element->classes[] = 'sub-menu dropdown';
        }
                Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
}*/
class foundation_navigation extends Walker_Nav_Menu {
  /**
    * @see Walker_Nav_Menu::start_lvl()
   * @since 1.0.0
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int $depth Depth of page. Used for padding.
  */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"sub-menu dropdown\">\n";
    }

    /**
     * @see Walker_Nav_Menu::start_el()
     * @since 1.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */

    function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $item_html = '';
        parent::start_el( $item_html, $object, $depth, $args );  

        //$output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';

        $classes = empty( $object->classes ) ? array() : ( array ) $object->classes;  

        if ( in_array('label', $classes) ) {
            $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '<label>$1</label>', $item_html );
        }

    if ( in_array('divider', $classes) ) {
      $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
    }

        $output .= $item_html;
    }

  /**
     * @see Walker::display_element()
     * @since 1.0.0
   * 
   * @param object $element Data object
   * @param array $children_elements List of elements to continue traversing.
   * @param int $max_depth Max depth to traverse.
   * @param int $depth Depth of current element.
   * @param array $args
   * @param string $output Passed by reference. Used to append additional content.
   * @return null Null on failure with no changes to parameters.
   */
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $element->has_children = !empty( $children_elements[$element->ID] );
        $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
        $element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

}



/**
 * Create pagination
 */

if ( ! function_exists( 'up546E_usertheme_pagination' ) ) :

function up546E_usertheme_pagination() {

global $wp_query;

$big = 999999999;

$links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'prev_next' => true,
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type' => 'list'
)
);

$pagination = str_replace('page-numbers','pagination',$links);

echo $pagination;

}

endif;

/**
 * Register Sidebars
 */

if ( ! function_exists( 'up546E_usertheme_widgets' ) ) :

function up546E_usertheme_widgets() {

	// Sidebar Right
	register_sidebar( array(
			'id' => 'usertheme_standard_sidebar',
			'name' => __( 'Standard Sidebar', 'usertheme' ),
			'description' => __( 'This sidebar is located on the right-hand side of each page.', 'foundation' ),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h5 class="widget_title">',
			'after_title' => '</h5>',
		) );

	register_sidebar( array(
			'id' => 'bbpress_sidebar',
			'name' => __( 'bbPress Sidebar', 'usertheme' ),
			'description' => __( 'This sidebar is displayed for bbPress related pages.', 'usertheme' ),
			'before_widget' => '<div>',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	}

add_action( 'widgets_init', 'up546E_usertheme_widgets' );

endif;

/**
 * Custom Avatar Classes
 */

if ( ! function_exists( 'up546E_usertheme_avatar_css' ) ) :

function up546E_usertheme_avatar_css($class) {
	$class = str_replace("class='avatar", "class='author_gravatar left ", $class) ;
	return $class;
}

add_filter('get_avatar','up546E_usertheme_avatar_css');

endif;



/** 
 * Comments Template
 */

if ( ! function_exists( 'up546E_usertheme_comment' ) ) :

function up546E_usertheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'usertheme' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'usertheme' ), '<span>', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header>
				<?php
					echo "<span class='th alignleft' style='margin-right:1rem;'>";
					echo get_avatar( $comment, 44 );
					echo "</span>";
					printf( '%2$s %1$s',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span class="label">' . __( 'Post Author', 'usertheme' ) . '</span>' : ''
					);
					printf( '<br><a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'usertheme' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p><?php _e( 'Your comment is awaiting moderation.', 'usertheme' ); ?></p>
			<?php endif; ?>

			<section>
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'usertheme' ), 'after' => ' &darr; <br><br>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

			</div>
		</article>
	<?php
		break;
	endswitch;
}
endif;

/**
 * Remove Class from Sticky Post
 */

if ( ! function_exists( 'up546E_usertheme_remove_sticky' ) ) :

function up546E_usertheme_remove_sticky($classes) {
  $classes = array_diff($classes, array("sticky"));
  return $classes;
}

add_filter('post_class','up546E_usertheme_remove_sticky');

endif;

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function up546E_usertheme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'usertheme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'up546E_usertheme_wp_title', 10, 2 );

/**
 * Retrieve Shortcodes
 * @see: http://fwp.drewsymo.com/shortcodes/
 */

$foundation_shortcodes = trailingslashit( get_template_directory() ) . 'inc/shortcodes.php';

if (file_exists($foundation_shortcodes)) {
	require( $foundation_shortcodes );
}



// Post Meta Widget
class uppm_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'uppm_widget', 

// Widget name will appear in UI
__('Post Meta Widget', 'uppm_widget_domain'), 

// Widget description
array( 'description' => __( 'Add post meta data in your sidebar', 'uppm_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
// before and after widget arguments are defined by themes
echo $args['before_widget'];
 ?>



<h5>Share</h5>
<h3>

<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="share-item"><i class="fi-social-facebook"></i> </a>

<a href="https://twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" class="share-item"><i class="fi-social-twitter"></i> </a>
 
<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-item"><i class="fi-social-google-plus"></i>  </a>
  
</h3>


<?php echo $args['after_widget'];
} 
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'uppm_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class uppm_widget ends here

// Register and load the widget
function up546E_wpb_load_widget() {
	register_widget( 'uppm_widget' );
}
add_action( 'widgets_init', 'up546E_wpb_load_widget' );








/* UserPress oEmbed Custom Meta Box Setup */
add_action( 'load-post.php', 'userpress_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'userpress_post_meta_boxes_setup' );

/* Meta box setup function. */
function userpress_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'userpress_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'userpress_save_post_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function userpress_add_post_meta_boxes() {

	add_meta_box(
		'featured-oembed',			// Unique ID
		esc_html__( 'oEmbed Featured Media', 'example' ),		// Title
		'userpress_post_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'high'					// Priority
	);
}


/* Display the post meta box. */
function userpress_post_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'userpress_post_nonce' ); ?>

	<p>
		<label for="featured-oembed"><?php _e( "(e.g. YouTube, Flickr, Funny or Die, etc.)", 'example' ); ?></label>
		<br />
		<input class="widefat" type="text" name="featured-oembed" id="featured-oembed" value="<?php echo esc_attr( get_post_meta( $object->ID, 'userpress_oembed', true ) ); ?>" size="30" />
	</p>
<?php }


/* Save the meta box's post metadata. */
function userpress_save_post_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['userpress_post_nonce'] ) || !wp_verify_nonce( $_POST['userpress_post_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( $_POST['featured-oembed'] );

	/* Get the meta key. */
	$meta_key = 'userpress_oembed';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}

?>