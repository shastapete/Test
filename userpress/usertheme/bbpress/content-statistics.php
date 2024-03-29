<?php

/**
 * Statistics Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Get the statistics
$stats = bbp_get_statistics(); ?>

<dl role="main">

	<?php do_action( 'bbp_before_statistics' ); ?>

	<dt><?php _e( 'Registered Users', 'bbpress' ); ?></dt>
	<dd>
		<?php echo esc_html( $stats['user_count'] ); ?>
	</dd>

	<dt><?php _e( 'Forums', 'bbpress' ); ?></dt>
	<dd>
		<?php echo esc_html( $stats['forum_count'] ); ?>
	</dd>

	<dt><?php _e( 'Topics', 'bbpress' ); ?></dt>
	<dd>
		<?php echo esc_html( $stats['topic_count'] ); ?>
	</dd>

	<dt><?php _e( 'Replies', 'bbpress' ); ?></dt>
	<dd>
		<?php echo esc_html( $stats['reply_count'] ); ?>
	</dd>

	<dt><?php _e( 'Topic Tags', 'bbpress' ); ?></dt>
	<dd>
		<?php echo esc_html( $stats['topic_tag_count'] ); ?>
	</dd>

	<?php if ( !empty( $stats['empty_topic_tag_count'] ) ) : ?>

		<dt><?php _e( 'Empty Topic Tags', 'bbpress' ); ?></dt>
		<dd>
			<?php echo esc_html( $stats['empty_topic_tag_count'] ); ?>
		</dd>

	<?php endif; ?>

	<?php if ( !empty( $stats['topic_count_hidden'] ) ) : ?>

		<dt><?php _e( 'Hidden Topics', 'bbpress' ); ?></dt>
		<dd>
			
				<abbr title="<?php echo esc_attr( $stats['hidden_topic_title'] ); ?>"><?php echo esc_html( $stats['topic_count_hidden'] ); ?></abbr>
			
		</dd>

	<?php endif; ?>

	<?php if ( !empty( $stats['reply_count_hidden'] ) ) : ?>

		<dt><?php _e( 'Hidden Replies', 'bbpress' ); ?></dt>
		<dd>
			
				<abbr title="<?php echo esc_attr( $stats['hidden_reply_title'] ); ?>"><?php echo esc_html( $stats['reply_count_hidden'] ); ?></abbr>
			
		</dd>

	<?php endif; ?>

	<?php do_action( 'bbp_after_statistics' ); ?>

</dl>

<?php unset( $stats );