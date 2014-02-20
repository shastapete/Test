<?php get_header(); ?>

<!-- MAIN ROW / WRAPPER -->


<div class="row">


<!-- Left Column -->
<div class="medium-9 columns">

<!-- Content Header -->
<div class="row">
<div class="medium-12 columns">

<h2 class="page-title">

<span class="right">
<div class="bbsub-container">
<div class="bbsub bb-button">
<?php bbp_forum_subscription_link(); ?>
</div>
</div>
</span>


<?php the_title(); ?></h2>

<?php bbp_breadcrumb(); ?>

</div>
</div><!-- End Content Header -->





<div class="row">

<!-- Page Content -->
<div class="medium-12 columns">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>





	
	<?php the_content(); ?>


			<?php endwhile; ?>
			
		<?php endif; ?>
</article>

</div>
</div><!-- END ROW -->


</div><!-- END LEFT COLUMN -->

<aside class="small-3 columns sidebar">

<?php if ( !is_user_logged_in() ) { ?> 
<p style="border:1px dotted #666; padding:10px;">Hello stranger, would you like to <a href=" <?php echo wp_registration_url(); ?>">create a new account?</a>. If you already have one <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">login</a></p>
<?php } ?>

	<?php if ( bbp_allow_search() ) : ?>

		<div class="bbp-search-form">

			<?php bbp_get_template_part( 'form', 'search' ); ?>

		</div>

	<?php endif; ?>
	
		<?php $args = array(
    'before' => '<h5>Tags</h5><ul><li>',
    'sep' => '</li><li>',
    'after' => '</li></ul>'
);
bbp_topic_tag_list( '', $args ); ?>

<?php if ( dynamic_sidebar('bbPress Sidebar') ) : elseif( current_user_can( 'edit_theme_options' ) ) : ?>

<!-- PLACEHOLDER -->

<?php endif; ?>
</aside>

</div><!-- END ROW / WRAPPER -->

<?php get_footer(); ?>
