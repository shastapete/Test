<?php 




/**
 * 
 * Alters the UserPress archive loop
 * @uses pre_get_posts hook
*/

function userpress_archive_filter( $query ) {
	
// Recently Created
	if ($_GET["view"] == 'created') {

// Recently Updated
	} elseif ($_GET["view"] == 'recently_modified') {
        $query->set( 'orderby', 'modified' );
        
// Recently Discussed
	} elseif ($_GET["view"] == 'recently_discussed') { 
        $query->set( 'orderby_last_comment', 'true' );

// Most Discussed    
	} elseif ($_GET["view"] == 'most_discussed') { 
        $query->set( 'orderby', 'comment_count' );
        $query->set( 'order', 'DESC' );       

// Alphabetical Order
	} elseif ($_GET["view"] == 'alpha') { 
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' ); 
        
// Create New Wiki -- Yes. This is an ugly hack. But it works.
	} elseif ($_GET["action"] == 'create') { 
        $query->set( 'posts_per_page', 1 );
	}
	
}


add_action( 'pre_get_posts', 'userpress_archive_filter' );




// Create New Wiki


if ($_GET["action"] == 'create') {

	add_action( 'template_redirect', 'upw_create_new_wiki' );
		function upw_create_new_wiki()
		{
   			 include( get_template_directory() . '/page.php' );
   			 exit();
		}


	add_filter( 'the_content', 'upw_insert_wiki_form' );
		function upw_insert_wiki_form($content)
		{
		global $blog_id, $wp_query, $wiki, $post, $current_user;
		$content = $wiki->get_new_wiki_form();
		return $content;
		}	
		
	add_filter( 'the_title', 'upw_new_wiki_title', 10, 2 );
		function upw_new_wiki_title($title, $id)
		{
		if ($id == get_the_id()) $title = "Create New Wiki";
		return $title;
		}			
}
?>