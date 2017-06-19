<?php
/**
 * Day View Single Event
 * This file contains one event in the day view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();
if ( isset( $venue_details['linked_name'] ) ) {
	$venue_name = $venue_details['linked_name'];
}
elseif ( isset( $venue_details['name'] ) ) {
	$venue_name = $venue_details['name'];
}
else {
	$venue_name = '';
}

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="even-list-wrapper">
	<div class="event-list-wrapper-top">
		<div class="tribe-events-event-image">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if(has_post_thumbnail()) : ?>
					<?php the_post_thumbnail( 'blog-thumbnail' ); ?>
				<?php else : ?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/thumb-event.png" alt="<?php the_title(); ?>">
				<?php endif; ?>
			</a>
		</div>

		<div class="tribe-events-event-date">
			<span class="dd"><?php echo tribe_get_start_date( null, false, 'd' ) ?></span>
			<span class="mm"><?php echo tribe_get_start_date( null, false, 'F' ) ?></span>
			<span class="yy"><?php echo tribe_get_start_date( null, false, 'Y' ) ?></span>
		</div>
	</div>

	<div class="event-list-wrapper-bottom">
		<div class="wraper-bottom-left">
			<!-- Event Title -->
			<?php do_action( 'tribe_events_before_the_event_title' ) ?>
			<h2 class="tribe-events-list-event-title entry-title summary">
				<a class="url" href="<?php echo tribe_get_event_link() ?>" title="<?php the_title() ?>" rel="bookmark">
					<?php the_title() ?>
				</a>
			</h2>
			<?php do_action( 'tribe_events_after_the_event_title' ) ?>

			<!-- Event Meta -->
			<?php do_action( 'tribe_events_before_the_meta' ) ?>
			<div class="tribe-events-event-meta vcard">
				<div class="author <?php echo esc_attr( $has_venue_address ); ?>">

					<?php if ( $venue_name ) : ?>
						<div class="tribe-events-venue-details">
							<?php echo wp_kses_data( $venue_name ); ?>
						</div>
					<?php endif; ?>

					<div class="time-details">
						<?php tokopress_tribe_event_time(); ?>
						<?php echo tokopress_tribe_event_recurringinfo('<br/><i class="fa fa-refresh"></i> '); ?>
					</div>

				</div>
			</div><!-- .tribe-events-event-meta -->
			<?php do_action( 'tribe_events_after_the_meta' ) ?>
		</div>
		<div class="wraper-bottom-right valign-wrapper">
			<a href="<?php echo tribe_get_event_link() ?>" class="more-link valign">
				<i class="fa fa-ticket"></i>
				<?php 
				if ( $cost = tribe_get_cost( null, true ) ) 
					printf( '<br/><span class="cost">%s</span>', $cost );
				?>
			</a>
		</div>
	</div>
</div>
