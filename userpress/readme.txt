=== Plugin Name ===
Contributors: booruguru, shastapete
Tags: wiki, collaborative, buddypress, bbpress, frontend, subscriptions
Requires at least: 3.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


UserPress is a collaborative media (wiki) platform built for WordPress.



== Description ==

NOTE: This is only the beta version of the software and it is only meant meant to be used for testing purposes.

This plugin includes a theme (`UserTheme`) that is automatically installed and activated once the UserPress plugin itself has been activated.

If you wish to use a custom theme you will need to make some modifications in order for it to work with UserPress. (However, in the future versions of the plugin, this will not be necessary.)

== Installation ==

1. Upload `userpress.zip`via your wp-admins plugins manager.

2. Update your permalinks once the plugin is activated. (Make sure your permalinks use post-names in their URIs).

3. Create a copy of your theme's archive.php file and name it archive-userpress_wiki.php (If your theme does not have an archive.php, you can use your index.php or single.php or anything that contains the basic layout of your site.)

4a. Now you need to modify the query in your PHP, which should look something like this...


if ( have_posts() ) :

while ( have_posts() ) : the_post(); 
 
<h2><?php the_title() ?></h2>

endwhile; 

endif;

4b. You need the follow above your query this...

if ($_GET["action"] == 'create') { 

echo $wiki->get_new_wiki_form(); 	    

} else {


4c. And you need to add the following below the query...

}

4d. In the end it should look something like this...

if ($_GET["action"] == 'create') { 

echo $wiki->get_new_wiki_form(); 	    

} else {

if ( have_posts() ) :

while ( have_posts() ) : the_post(); 
 
<h2><?php the_title() ?></h2>

endwhile; 

endif;

}

6. Change the title of your page to "Wiki" (or give it some other name you prefer).

7. Save/upload the modifications.

8. Done. Visit yourwebsite.com/wiki/frontpage/ in order to view your new wiki section.

NOTE: Feel free to make additional modifications to your theme files.


== Frequently Asked Questions ==

= How can I access my wiki home page? =

http://yourwebsite.com/wiki/frontpage/

Once you activate UserPress, a wiki page called "Frontpage" is automatically created. This will serve as the main page of your WordPress wiki (http://yourwebsite.com/wiki/frontpage/). 

Also, if you try to access "http://yourwebsite.com/wiki/" UserPress will automatically forward you to the "frontpage".


= How can I post wiki articles? =

You can post wiki articles by visiting "http://yourwebsite.com/wiki/?action=create". (You can post wiki articles using wp-admin under the "Wiki" sidebar menu item.) 


== Changelog ==

* Added Auto-Update Support