<?php get_header(); ?>

<!-- MAIN ROW / WRAPPER -->


<div class="row">
<!-- Left Column -->
<div class="medium-9 columns">




<!-- Content Header -->
<div class="row">
<div class="medium-12 columns">
<h2 class="page-title">
			    <?php  if ($_GET["action"] == 'create') { 
				echo "Create New Wiki"; }
				else { echo "Wiki"; } ?> 
</h2>
				
<div class="userpress_wiki_tabs userpress_wiki_tabs_top">
<div class="subtitle">

<ul class="right">
    <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>?action=create"><i class="fi-page-new"></i> Create New Wiki</a></li>

<?php //list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

$taxonomy     = 'userpress_wiki_flags';
$orderby      = 'name';
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$empty        = 0;

$flags = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);
?>

<li><a href="#" data-dropdown="drop-flag"> <i class="fi-flag"></i> Flags</a></li>
		<ul id="drop-flag" data-dropdown-content class="f-dropdown">
		<?php wp_list_categories( $flags ); ?>
		</ul>

<li><a href="#" data-dropdown="drop-etc"> <i class="fi-home"></i> Etc.</a></li>
		<ul id="drop-etc" data-dropdown-content class="f-dropdown">
        <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>frontpage"><i class="fi-home"></i> Frontpage</a></li>
        <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>?view=created"><i class="fi-burst-new"></i> New Articles</a></li>
        <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>?view=recently_discussed"><i class="fi-torsos-all"></i> Recently Discussed</a></li>
        <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>?view=most_discussed"><i class="fi-comments"></i> Most Discussed</a></li>
        <li><a href="<?php echo get_post_type_archive_link('userpress_wiki') ; ?>?view=alpha"><i class="fi-page-multiple"></i> Alphabetical Order</a></li>
        </br>
		</ul>
</ul>

<ul class="left">
<?php  if ($_GET["action"] !== 'create') { 
		echo $wp_query->found_posts . " result(s) found"; } ?>
</ul>

</div>
</div>

</div>
</div><!-- End Content Header -->





<div class="row">

<!-- Page Content -->
<div class="medium-12 columns left ">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 

// CREATE NEW WIKI
if ($_GET["action"] == 'create') { 

echo $wiki->get_new_wiki_form(); 	    

} else {

if ( have_posts() ) :

while ( have_posts() ) : the_post(); 
 
get_template_part( 'loop', 'list' );


endwhile; 

endif;

up546E_usertheme_pagination();

}?>

</article>
</div>
</div><!-- END ROW -->


</div><!-- END LEFT COLUMN -->

<?php get_sidebar(); ?>


</div><!-- END ROW / WRAPPER -->

<?php get_footer(); ?>
