<?php get_header(); ?>

<!-- MAIN ROW / WRAPPER -->


<div class="row">
<!-- Left Column -->
<div class="medium-9 columns">




<!-- Content Header -->
<div class="row">
<div class="medium-12 columns">



<h2 class="page-title">
"<?php the_search_query() ?>"</h2>

<h3 class="subtitle">
<?php echo $wp_query->found_posts ?> result(s) found
</h3>


</div>
</div><!-- End Content Header -->





<div class="row">

<!-- Page Content -->
<div class="medium-12 columns left ">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

<?php get_template_part( 'loop', 'list' ); ?>


<?php endwhile; ?>
			
		<?php endif; ?>

		<?php up546E_usertheme_pagination(); ?>
</article>

</div>
</div><!-- END ROW -->


</div><!-- END LEFT COLUMN -->

<?php get_sidebar(); ?>


</div><!-- END ROW / WRAPPER -->

<?php get_footer(); ?>


