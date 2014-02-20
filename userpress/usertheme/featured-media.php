	<?php if (get_post_meta($post->ID, 'userpress_oembed', true) ) { ?>

<div class="row featured-media">
<div class="medium-12 columns">
<div class="flex-video widescreen">
<?php echo wp_oembed_get( get_post_meta($post->ID, "userpress_oembed", $single = true ) , array("width"=>755)); ?>
</div>
</div>
</div>

			
	<?php		} elseif ( has_post_thumbnail() ) { ?>

<div class="row featured-media text-centered">
<div class="medium-12 columns">

	<center><?php the_post_thumbnail( 'featured-image' ); // insert "custom size" image ?></center>
	
</div>				
</div>				

	
<?php } ?>




