<!-- BEGIN LOOP -->

<div class="page-result row" >


<div class="medium-3 columns">
<?php if ( has_post_thumbnail() ) { ?> 

<a href='<?php the_permalink() ?>'><?php the_post_thumbnail( 'featured-thumbnail' ); ?></a> 

<?php } else { ?>

<div class='thumbnail-placeholder'><a href='<?php the_permalink() ?>' class='fill-div' ></a></div>
<?php } ?>	
</div>

<div class="medium-9 columns">
<?php if ( has_category() ) { ?>
<h6 class="the-category"><?php the_category(', '); ?></h6>
<?php } ?>
<h4 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
<?php the_tags('<span class="radius secondary label">','</span><span class="radius secondary label">','</span>'); ?>
</div>



</div>

<!-- END LOOP -->