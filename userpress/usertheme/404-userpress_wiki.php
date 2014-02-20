<?php get_header(); ?>

<!-- MAIN ROW / WRAPPER -->


<div class="row">
<!-- Left Column -->
<div class="medium-9 columns">




<!-- Content Header -->
<div class="row">
<div class="medium-12 columns">

<h2 class="page-title">Error (404)</h2>

<h3 class="subtitle">Page Not Found</h3>


</div>
</div><!-- End Content Header -->





<div class="row">

<!-- Page Content -->
<div class="medium-12 columns left ">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<p>The wiki page you requested could not be found (or it doesn't exist). But you can go ahead and create a new page titled <a href="<?php echo get_post_type_archive_link( 'userpress_wiki' ); ?>?action=create&wtitle=<?php echo up546E_userpress_slug(); ?>"><?php echo urldecode(up546E_userpress_slug()); ?></a>.</p>

<!-- Did you mean -->
<?php 
$q = up546E_userpress_slug();
$args = array(
  'post_type' => 'any',
  'post_status' => 'publish',
  'name' => $q,
  'posts_per_page' => 5
);
$query = new WP_Query($args); //query posts by slug
if(empty($query->posts)){ //search for posts
  $q = str_replace('-', ' ', $q);
  $args = array(
    'post_type' => 'any',
    'post_status' => 'publish',
    's' => $q,
    'posts_per_page' => 5
  );
  $query->query($args); 
}
if(!empty($query->posts)):
  ?>
  <h5>Possible matches:</h5>
  <ul class="posts-list">
  <?php echo up546E_userpress_404_posts($query->posts);?>
  </ul>
<?php endif;?>
</article>

</div>
</div><!-- END ROW -->


</div><!-- END LEFT COLUMN -->

<?php get_sidebar(); ?>


</div><!-- END ROW / WRAPPER -->

<?php get_footer(); ?>



