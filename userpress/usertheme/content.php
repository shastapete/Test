<?php
/**
 * Content
 *
 * Displays content shown in the 'index.php' loop, default for 'standard' post format
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header>
                <hgroup>
                
                        <h3 class="search-result"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'usertheme' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <?php if ( is_sticky() ) : ?><span class="right radius secondary label"><?php _e( 'Sticky', 'usertheme' ); ?></span><?php endif; ?>
                        <h6>Written by <?php the_author_link(); ?> on <?php the_time(get_option('date_format')); ?></h6>
                </hgroup>
        </header>
        
<?php the_content('Read more...'); ?>	
	<hr>

</article>