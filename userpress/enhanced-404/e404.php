<?php



/*The function below determines the slug of URIs. 
This is useful for 404 error pages and especially useful for allow users 
to quickly create new pages for pages that do not exist. 


via http://www.webdesignerdepot.com/2013/02/how-to-build-effective-404-error-pages-in-wordpress/

This is separate from the UserPress Wiki since it might be expanded into a standalone plugin.

*/



function up546E_userpress_slug(){
  global $wp;
  $q = $wp->request;
  $q = preg_replace("/(\.*)(html|htm|php|asp|aspx)$/","",$q);
  $parts = explode('/', $q);
  $q = end($parts);
  return $q;
}


function up546E_userpress_404_posts($posts){
  if(empty($posts))
  return '';
  $list = array();
  foreach($posts as $cpost) {
    $title = get_the_title($cpost);
    $url = get_permalink($cpost);
    $list[] = "<li><a href='{$url}'>{$title}</a></li>"; 
  }
  return implode('', $list);
}


?>