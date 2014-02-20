<?php
/**
 * Sidebar
 *
 * Content for our sidebar, provides prompt for logged in users to create widgets
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */
?>

<!-- Sidebar -->
<aside class="medium-3 columns sidebar">
<?php up546E_bppostsubbutton($postID, $mode);  ?>

<?php if ( !is_user_logged_in() ) { ?> 
<p style="border:1px dotted #666; padding:10px;">Hello stranger, would you like to <a href=" <?php echo wp_registration_url(); ?>">create a new account?</a>. If you already have one <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">login</a></p>
<?php } ?>

<? /* php if (class_exists( 'BuddyPress' ) ) { 


			if ( bp_is_page( BP_GROUPS_SLUG ) ) { 

			bp_directory_groups_search_form();

			} elseif ( bp_is_user_messages() )  { bp_message_search_form();  

			} elseif ( bp_is_directory() )  { bp_directory_members_search_form(); 

			} else { get_search_form();  }
			
		} 
			
else { get_search_form();  }

*/?>

<?php if ( dynamic_sidebar('Standard Sidebar') ) : elseif( current_user_can( 'edit_theme_options' ) ) : ?>

<!-- PLACEHOLDER -->

<?php endif; ?>

</aside>
<!-- End Sidebar -->


<!-- BEGIN INFOBOX MODAL -->
<div id="infoboxModal" class="infobox-modal" data-reveal>
<span class="right"><small><a class="close-reveal-modal">Close Window</a></small></span>
<div class="infobox">
<?php echo get_post_meta($post->ID, 'userpress_wiki_infobox', true); ?>

</div>

</div>
<!-- END INFOBOX MODAL -->