<?php
/**
 * Footer
 *
 * Displays content shown in the footer section
 *
 * @package WordPress
 * @subpackage UserTheme, for WordPress

 */
?>


<!-- Footer -->
<div class="footer">
<div class="row">
	    <div class="medium-6 columns">
<p>Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo( $name ); ?></p>
		</div>


	    <div class="medium-6 columns">
<p class="right"><?php if (class_exists( 'Wiki' ) ) { ?>
powered by <a href="http://userpress.org" target="_blank">UserPress</a>
<?php } else { ?>
"UserTheme" designed by <a href="http://userpress.org" target="_blank">UserPress</a>
<?php } ?>
</p>
	</div>


</div>
<!-- End Footer -->
</div>


<?php wp_footer(); ?>
</body>


</html>