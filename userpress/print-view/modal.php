<!DOCTYPE html>

<html>
<head>
<base target="_top">
	<title>
		<?php
		global $wpdb, $page;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		?>
	</title>
	<meta name="robots" content="noindex,nofollow">

<link rel="stylesheet" type="text/css" media="all" href="<?php echo plugins_url('css/foundation.min.css',__FILE__); ?>" />

<link rel="stylesheet" type="text/css" media="all" href="<?php echo plugins_url('css/normalize.css',__FILE__); ?>" />

<style>
body {
margin:0;
}

#modal-content {
margin-top:-10px;
}

#fixed-bottom {
position:fixed;
bottom:0;
width:100%;
height:25px;
padding-top:5px;
padding-bottom:10px;
padding-right:30px;
text-align:right;
border-top:1px solid #ccc;
background:#fff;
}

#fixed-bottom a {
margin-right:30px;
color:#111;
font-size:0.8em;
}

.article-content {
max-width:550px;
margin:auto;
margin-bottom:40px;
}

.article-title{
font-weight:bold;
}

h4 {
margin-bottom:-20px;
}
</style>
</head>

<body>





<div id="modal-content" class="clearfix">


	<?php
	if ( have_posts() ) {
		while ( have_posts() ) : the_post();
			?>
			
				<h4><?php bloginfo( 'name' ); ?></h4>
				<h1 class="article-title"><?php the_title(); ?></h1>
				<div class="article-content"><?php the_content(); ?></div>
		<?php
		endwhile;
	}
	?>


	
</div>

<div id="fixed-bottom">
<a href="<?php the_permalink(); ?>">View Full Page</a>
</div>
</body>
</html>