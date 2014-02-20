<?php
/**
 * Author Box
 *
 * Displays author box with author description and thumbnail on single posts
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */
?>

<?php if ( get_the_author_meta('description') ) : ?>




		<div class="author-box">
<p><?php echo get_the_author_meta('description'); ?></p>

<p><small>Browse additional contributions by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>.</small></p>

</div>
<?php endif; ?>