<?php add_action( 'template_redirect', 'userpress_frontpage' );

function userpress_frontpage(){
if ( 'userpress_wiki' == get_post_type() AND !is_tax() AND !is_search() AND !is_singular( 'userpress_wiki' ) AND ($_GET['view'] == NULL) AND ($_GET['action'] == NULL) )
{ wp_redirect(get_post_type_archive_link( 'userpress_wiki' ).'frontpage' ); exit; }
}

?>