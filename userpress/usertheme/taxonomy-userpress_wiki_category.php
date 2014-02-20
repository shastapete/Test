<?php get_header(); ?>

<div class="page-head">
<div class="row">
<div class="medium-12 columns">


<h2 class="page-title">
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?>
</h2>

<h3 class="subtitle"><?php echo $wp_query->found_posts ?> result(s) found</h3>
</h3>
</div>
</div>
</div>



<!-- Main Content -->
<div class="row" >
<div class="medium-9 columns">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

<?php get_template_part( 'loop', 'list' ); ?>


<?php endwhile; ?>
			
		<?php endif; ?>

		<?php up546E_usertheme_pagination(); ?>

</div><!-- End Main Content -->

<?php get_sidebar(); ?>

</div><!-- End Page -->

<?php get_footer(); ?>

