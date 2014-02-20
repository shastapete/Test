<?php get_header(); ?>


<div class="row">

<!-- Main Content -->


<div class="medium-9 columns">


<div class="row">
<div class="medium-12 columns">
<?php get_template_part( 'featured', 'media' ); ?>


<h2 class="page-title">
<?php the_title(); ?></h2>

<?php if (get_post_meta($post->ID, 'userpress_wiki_subtitle', true) ) { ?>
<h3 class="subtitle">
<?php echo get_post_meta($post->ID, 'userpress_wiki_subtitle', true); ?>
</h3>
<?php } ?>
</div>
</div>




<div class="row">
<div class="medium-12 columns">
<article id="post-<?php the_ID(); ?>" >
<?php if (class_exists('up546E_UserPress_Toc')) { icon_toc_page(); } ?>				


	
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>





	
	<?php the_content(); ?>

	<footer>

		<p><?php wp_link_pages(); ?></p>


<?php if ( get_the_author_meta('description') ) : ?>

<?php get_template_part( 'author', 'box' ); ?>


<?php endif; ?>

		<?php comments_template(); ?>

	</footer>


<hr />


			<?php endwhile; ?>
			
		<?php endif; ?>
</article>
</div>
</div>

</div><!-- End Main Content -->

<?php get_sidebar(); ?>
</div>
<!-- End Page -->

<?php get_footer(); ?>
