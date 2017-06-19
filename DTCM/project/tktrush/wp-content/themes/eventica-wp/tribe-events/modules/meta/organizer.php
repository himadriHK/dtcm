<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
if ( empty( $organizer_ids ) )
	return;
$multiple = count( $organizer_ids ) > 1;
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"> <?php echo tribe_get_organizer_label( ! $multiple ); ?> </h3>
	<table>
		<?php do_action( 'tribe_events_single_meta_organizer_section_start' ) ?>

		<?php foreach ( $organizer_ids as $key => $organizer_id ) : ?>
			<?php
			$organizer_page = get_permalink( $organizer_id );
			$phone = function_exists( 'tribe_get_organizer_phone' ) ? tribe_get_organizer_phone($organizer_id) : '';
			$email = function_exists( 'tribe_get_organizer_email' ) ? tribe_get_organizer_email($organizer_id) : '';
			$website_url = function_exists( 'tribe_get_organizer_website_url' ) ? tribe_get_organizer_website_url($organizer_id) : '';
			?>

			<tr>
				<td class="fn org" colspan="2" <?php if ( $key > 1 ) echo 'style="padding-top:25px;"';?>> 
					<?php if ( of_get_option('tokopress_events_show_organizer_link') ): ?>
						<a href="<?php echo esc_url( $organizer_page ); ?>">
							<strong><?php echo tribe_get_organizer($organizer_id) ?> </strong>
						</a>
					<?php else : ?>
						<strong><?php echo tribe_get_organizer($organizer_id) ?> </strong>
					<?php endif ?>
				</td>
			</tr>

			<?php if ( ! empty( $phone ) ): ?>
				<tr>
					<th> <?php _e( 'Phone:', 'tokopress' ) ?> </th>
					<td class="tel"> <?php echo wp_kses_data( $phone ) ?> </td>
				</tr>
			<?php endif ?>

			<?php if ( ! empty( $email ) ): ?>
				<tr>
					<th> <?php _e( 'Email:', 'tokopress' ) ?> </th>
					<td class="email"> <?php echo wp_kses_data( $email ) ?> </td>
				</tr>
			<?php endif ?>

			<?php if ( ! empty( $website_url ) ): ?>
				<tr>
					<th> <?php _e( 'Website:', 'tokopress' ) ?> </th>
					<td class="url"> 
						<a href="<?php echo esc_url( $website_url ); ?>">
							<?php _e( 'Visit Organizer Website', 'tokopress' ); ?>
						</a> 
					</td>
				</tr>
			<?php endif ?>

		<?php endforeach; ?>

		<?php do_action( 'tribe_events_single_meta_organizer_section_end' ) ?>
	</table>
</div>