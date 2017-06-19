<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h3 class="tribe-events-single-section-title"> <?php _e( 'Details', 'tokopress' ) ?> </h3>
	<table>

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		if ( class_exists('Tribe__Date_Utils') ) {
			$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		}
		elseif ( class_exists('Tribe__Events__Date_Utils') ) {
			$time_format = get_option( 'time_format', Tribe__Events__Date_Utils::TIMEFORMAT );
		}
		$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

		$start_datetime = tribe_get_start_date();
		$start_date = tribe_get_start_date( null, false );
		$start_time = tribe_get_start_date( null, false, $time_format );
		if ( class_exists('Tribe__Date_Utils') ) {
			$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );
		}
		elseif ( class_exists('Tribe__Events__Date_Utils') ) {
			$start_ts = tribe_get_start_date( null, false, Tribe__Events__Date_Utils::DBDATEFORMAT );
		}

		$end_datetime = tribe_get_end_date();
		$end_date = tribe_get_end_date( null, false );
		$end_time = tribe_get_end_date( null, false, $time_format );
		if ( class_exists('Tribe__Date_Utils') ) {
			$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );
		}
		elseif ( class_exists('Tribe__Events__Date_Utils') ) {
			$end_ts = tribe_get_end_date( null, false, Tribe__Events__Date_Utils::DBDATEFORMAT );
		}

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>

		<tr>
			<th> <?php _e( 'Start:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $start_ts, $start_date ); ?>
			</td>
		</tr>

		<tr>
			<th> <?php _e( 'End:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr dtend" title="%s">%s</abbr>', $end_ts, $end_date ); ?>
			</td>
		</tr>

		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>

		<tr>
			<th> <?php _e( 'Date:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $start_ts, $start_date ); ?>
			</td>
		</tr>

		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>

		<tr>
			<th> <?php _e( 'Start:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $start_ts, $start_datetime ); ?>
			</td>
		</tr>

		<tr>
			<th> <?php _e( 'End:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr dtend" title="%s">%s</abbr>', $end_ts, $end_datetime ); ?>
			</td>
		</tr>

		<?php
		// Single day events
		else :
			?>

		<tr>
			<th> <?php _e( 'Date:', 'tokopress' ) ?> </th>
			<td>
				<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $start_ts, $start_date ); ?>
			</td>
		</tr>

		<tr>
			<th> <?php _e( 'Time:', 'tokopress' ) ?> </th>
			<td>
				<?php if ( $start_time == $end_time )  : ?>
					<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $end_ts, $start_time ); ?>
				<?php else : ?>
					<?php printf( '<abbr class="tribe-events-abbr updated published dtstart" title="%s">%s</abbr>', $end_ts, $start_time . $time_range_separator . $end_time ); ?>
				<?php endif; ?>
			</td>
		</tr>

		<?php endif ?>

		<?php if ( function_exists( 'tribe_is_recurring_event' ) && function_exists( 'tribe_get_recurrence_text' ) && tribe_is_recurring_event( get_the_ID() ) ) : ?>

		<tr>
			<th> <?php _e( 'Recurring:', 'tokopress' ) ?> </th>
			<td>
				<?php echo tribe_get_recurrence_text( get_the_ID() ); ?>
				<?php if ( function_exists( 'tribe_all_occurences_link' ) ) : ?>
					<?php printf( '<br/><a href="%s">%s</a>', esc_url( tribe_all_occurences_link( get_the_ID(), false ) ), __( '(See All)', 'tokopress' ) ); ?>
				<?php endif ?>
			</td>
		</tr>
		<?php endif ?>

		<?php
		$cost = tribe_get_formatted_cost();
		if ( ! empty( $cost ) ):
			?>
		<tr>
			<th> <?php _e( 'Cost:', 'tokopress' ) ?> </th>
			<td class="tribe-events-event-cost"> <?php echo esc_html( tribe_get_formatted_cost() ) ?> </td>
		</tr>
		<?php endif ?>

		<?php
		echo tribe_get_event_categories(
			get_the_id(), array(
				'before'       => '',
				'sep'          => ', ',
				'after'        => '',
				'label'        => sprintf( esc_html__( '%s Categories', 'tokopress' ), tribe_get_event_label_singular() ),
				'label_before' => '<tr><th>',
				'label_after'  => '</th>',
				'wrap_before'  => '<td class="tribe-events-event-categories">',
				'wrap_after'   => '</td></tr>'
			)
		);
		?>

		<?php echo tribe_meta_event_tags( sprintf( esc_html__( '%s Tags:', 'tokopress' ), tribe_get_event_label_singular() ), ', ', false ) ?>

		<?php
		$website = tribe_get_event_website_url();
		if ( ! empty( $website ) ):
			?>
		<tr>
			<th> <?php _e( 'Website:', 'tokopress' ) ?> </th>
			<td class="tribe-events-event-url"> 
				<a href="<?php echo esc_url( $website ); ?>">
					<?php _e( 'Visit Event Website', 'tokopress' ); ?>
				</a> 
			</td>
		</tr>
		<?php endif ?>

		<?php if ( function_exists( 'tribe_get_custom_fields' ) ) : ?>
			<?php $fields = tribe_get_custom_fields(); ?>
			<?php foreach ( $fields as $name => $value ): ?>
				<tr>
					<th> <?php echo $name ?> </th>
					<td class="tribe-meta-value"> <?php echo $value ?> </td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
</table>
		<?php do_action( 'tribe_events_single_meta_details_section_end' ) ?>
	
</div>