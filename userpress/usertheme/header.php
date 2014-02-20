<?php 
/**
 * Header
 *
 * Setup the header for our theme
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />

<title><?php wp_title('|', true, 'right'); ?></title>

<?php 

/*Don't remove this. */

wp_head(); 

?>
 


 



  
  
</head>

<body <?php body_class(); ?>>

<div class="header">
<div class="row">


 <nav class="top-bar" data-topbar>
                <ul class="title-area">
                        <li class="name"><h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1></li>
                        
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                </ul>
                <section class="top-bar-section">
                        <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class' => 'left', 'container' => '', 'fallback_cb' => 'false', 'walker' => new foundation_navigation() ) ); ?>


<!-- Right Nav Section --> 

<ul class="right"> 


<?php if ( is_user_logged_in() ) { ?>

<?php if (class_exists( 'BuddyPress' ) ) { ?>










<li class="has-dropdown"> 
<?php if ( bp_is_active( 'settings' ) ) { ?>
<a href="#">  <i class="step fi-torso"></i> <?php echo get_the_author_meta( 'first_name', get_current_user_id() ); } ?>  <?php if ( bp_is_active( 'messages' ) ) { ?> 
<span style="color:#3364F7;">(<?php echo messages_get_unread_count(); ?>)</span>
<?php } ?></a> 



<ul class="dropdown" > 

<?php if ( bp_is_active( 'messages' ) ) { ?> 
<li><a href="<? echo bp_loggedin_user_domain().'messages/'; ?>">Inbox <span style="color:#3364F7;">(<?php echo messages_get_unread_count(); ?>)</span></a> </li>
<?php } ?>

<?php if (function_exists( 'up546E_bps_scripts' ) ) { ?>
<li><a href="<? echo bp_loggedin_user_domain().'subscriptions/'; ?>">Subscriptions</a> </li>
<?php } ?>

<?php if ( bp_is_active( 'friends' ) ) { ?>
<li class="current"><a href="<? echo bp_loggedin_user_domain().'friends/'; ?>">Friends</a></li>
<?php } ?>

<?php if ( bp_is_active( 'activity' ) ) { ?>
<li class="current"><a href="<? echo bp_loggedin_user_domain().'activity/'; ?>">Activity</a></li>
<?php } ?>

<li><a href="<? echo bp_loggedin_user_domain().'settings/'; ?>">Settings</a> </li>

<li><a href="<?php echo wp_logout_url( $_SERVER['REQUEST_URI'] ); ?>" title="Logout">Logout</a></li>

</ul>

</li>





<?php } ?>

<?php } else  { ?>
<?php if ( get_option('users_can_register') ) { ?>
<li><a href="<?php echo wp_registration_url(); ?>">Register</a></li>

<li><a href="<?php echo wp_login_url( get_permalink() ); ?>">Login</a></li>


<?php } } ?>



<li class="has-dropdown"> 
<a href="#"><i class="step fi-magnifying-glass"></i></a> 



<ul class="dropdown search-dropdown" style="width:280px; background:#f2f2f2; padding:10px 10px 15px 10px; border:1px solid #eee;"> 

<?php get_search_form(); ?>


</ul>

</li>
</ul> 
                </section>                
        </nav>




</div>
</div>


<div style="clear:both"></div>


<style>
.ac_results {
	padding: 0;
	margin: 0;
	list-style: none;
	position: absolute;
	z-index: 10000;
	display: none;
	border-width: 1px;
	border-style: solid;
}
 
.ac_results li {
	padding: 2px 5px;
	white-space: nowrap;
	text-align: left;
}
 
.ac_over {
	cursor: pointer;
}
 
.ac_match {
	text-decoration: underline;
}
</style>