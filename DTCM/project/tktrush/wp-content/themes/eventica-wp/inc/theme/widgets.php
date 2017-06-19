<?php

function tokopress_widgets_init() {
	register_widget('TokoPress_Widget_Recent_Posts');
	if( class_exists( 'Tribe__Events__Main' ) ) {
		register_widget('TokoPress_Widget_Upcoming_Events');
		register_widget('TokoPress_Widget_Past_Events');
		register_widget('TokoPress_Widget_Featured_Event');
	}
}
add_action('widgets_init', 'tokopress_widgets_init');

class TokoPress_Widget_Recent_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_recent_posts', 'description' => __( "Your site&#8217;s most recent posts with thumbnail.", 'tokopress') );
		parent::__construct('tokopress-recent-posts', '::TP:: '.__('Recent Posts', 'tokopress'), $widget_ops);
		$this->alt_option_name = 'tokopress_widget_recent_posts';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'tokopress_widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post( $cache[ $args['widget_id'] ] );
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'tokopress' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		wp_reset_postdata();

		$r = new WP_Query( array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) );

		if ($r->have_posts()) :
		?>
		<?php printf( '%s', $args['before_widget'] ); ?>
		<?php if ( $title ) {
			printf( '%s', $args['before_title'] . $title . $args['after_title'] );
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<?php if( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" title="">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</a>
				<?php endif; ?>
				<a class="tp-entry-title" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<span class="tp-entry-date"><?php echo get_the_date(); ?></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php printf( '%s', $args['after_widget'] ); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'tokopress_widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['tokopress_widget_recent_posts']) )
			delete_option('tokopress_widget_recent_posts');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('tokopress_widget_recent_posts', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tokopress' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of events to show:', 'tokopress' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}

class TokoPress_Widget_Upcoming_Events extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_upcoming_events', 'description' => __( "Your upcoming events with thumbnail.", 'tokopress') );
		parent::__construct('tokopress-upcoming-events', '::TP:: '.__('Upcoming Events', 'tokopress'), $widget_ops);
		$this->alt_option_name = 'tokopress_widget_upcoming_events';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'tokopress_widget_upcoming_events', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post( $cache[ $args['widget_id'] ] );
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Upcoming Events', 'tokopress' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		wp_reset_postdata();

		$r = new WP_Query( array(
			'post_type'				=> array(Tribe__Events__Main::POSTTYPE),
			'posts_per_page'		=> $number,
			'orderby'        		=> 'event_date',
			'order'          		=> 'ASC',
			//required in 3.x
			'eventDisplay'			=> 'list'
		) );

		if ($r->have_posts()) :
		?>
		<?php printf( '%s', $args['before_widget'] ); ?>
		<?php if ( $title ) {
			printf( '%s', $args['before_title'] . $title . $args['after_title'] );
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<?php if( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" title="">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</a>
				<?php endif; ?>
				<a class="tp-entry-title" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<span class="tp-entry-date"><?php echo tribe_events_event_schedule_details(); ?></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php printf( '%s', $args['after_widget'] ); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'tokopress_widget_upcoming_events', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['tokopress_widget_upcoming_events']) )
			delete_option('tokopress_widget_upcoming_events');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('tokopress_widget_upcoming_events', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tokopress' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of events to show:', 'tokopress' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}


class TokoPress_Widget_Past_Events extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_past_events', 'description' => __( "Your past events with thumbnail.", 'tokopress') );
		parent::__construct('tokopress-past-events', '::TP:: '.__('Past Events', 'tokopress'), $widget_ops);
		$this->alt_option_name = 'tokopress_widget_past_events';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'tokopress_widget_past_events', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post( $cache[ $args['widget_id'] ] );
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Past Events', 'tokopress' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		$r = new WP_Query( array(
			'post_type'				=> array(Tribe__Events__Main::POSTTYPE),
			'posts_per_page'		=> $number,
			'orderby'        		=> 'event_date',
			'order'          		=> 'DESC',
			//required in 3.x
			'eventDisplay'			=> 'past'
		) );

		if ($r->have_posts()) :
		?>
		<?php printf( '%s', $args['before_widget'] ); ?>
		<?php if ( $title ) {
			printf( '%s', $args['before_title'] . $title . $args['after_title'] );
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<?php if( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" title="">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</a>
				<?php endif; ?>
				<a class="tp-entry-title" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<span class="tp-entry-date"><?php echo tribe_events_event_schedule_details(); ?></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php printf( '%s', $args['after_widget'] ); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'tokopress_widget_past_events', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['tokopress_widget_past_events']) )
			delete_option('tokopress_widget_past_events');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('tokopress_widget_past_events', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tokopress' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of events to show:', 'tokopress' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}


class TokoPress_Widget_Featured_Event extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_featured_event', 'description' => __( "Your featured event by ID.", 'tokopress') );
		parent::__construct('tokopress-featured-event', '::TP:: '.__('Featured Event', 'tokopress'), $widget_ops);
		$this->alt_option_name = 'tokopress_widget_featured_event';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'tokopress_widget_featured_event', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			// echo wp_kses_post( $cache[ $args['widget_id'] ] );
			// return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Featured Event', 'tokopress' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$eventid = absint( $instance['eventid'] );

		$showcontent = in_array( $instance['showcontent'], array( 'no', 'excerpt', 'full' ) ) ? $instance['showcontent'] : 'no';

		$buttontext = ( ! empty( $instance['buttontext'] ) ) ? $instance['buttontext'] : __( 'Register Now', 'tokopress' );

		$r_args = array(
			'post_status'	=>'publish',
			'post_type'		=>array(Tribe__Events__Main::POSTTYPE),
		);
		if ( intval( $eventid ) > 0 ) {
			$r_args['post__in'] = array( intval( $eventid ) );
			$r_args['eventDisplay'] = 'custom';
		}
		else {
			$r_args['posts_per_page'] = 1;
			$r_args['eventDisplay'] = 'list';
		}
		$r = new WP_Query( $r_args );

		if ($r->have_posts()) :
		?>
		<?php printf( '%s', $args['before_widget'] ); ?>
		<?php if ( $title ) {
			printf( '%s', $args['before_title'] . $title . $args['after_title'] );
		} ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php if( has_post_thumbnail() ) : ?>
					<a class="tp-event-image" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'blog-thumbnail' ); ?>
					</a>
				<?php endif; ?>
				<h4 class="tp-event-title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h4>
				<p class="tp-event-date"><?php echo tribe_events_event_schedule_details(); ?></p>
				<?php if( $showcontent == 'excerpt' ) : ?>
					<div class="tp-event-content"><?php the_excerpt(); ?></div>
				<?php elseif( $showcontent == 'full' ) : ?>
					<div class="tp-event-content"><?php the_content(); ?></div>
				<?php endif; ?>
				<p class="tp-event-button"><a class="btn" href="<?php the_permalink(); ?>"><?php echo $buttontext; ?></a></p>
		<?php endwhile; ?>
		<?php printf( '%s', $args['after_widget'] ); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'tokopress_widget_featured_event', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['eventid'] = (int) $new_instance['eventid'] > 0 ? (int) $new_instance['eventid'] : '';
		$instance['showcontent'] = 'date';
		if ( in_array( $new_instance['showcontent'], array( 'no', 'excerpt', 'full' ) ) )
			$instance['showcontent'] = $new_instance['showcontent'];
		$instance['buttontext'] = strip_tags($new_instance['buttontext']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['tokopress_widget_featured_event']) )
			delete_option('tokopress_widget_featured_event');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('tokopress_widget_featured_event', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$eventid    = isset( $instance['eventid'] ) ? esc_attr( $instance['eventid'] ) : '';
		$showcontent   = isset( $instance['showcontent'] ) ? esc_attr( $instance['showcontent'] ) : '';
		$buttontext     = isset( $instance['buttontext'] ) ? esc_attr( $instance['buttontext'] ) : '';
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'tokopress' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'eventid' ) ); ?>"><?php _e( 'Event ID:', 'tokopress' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'eventid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'eventid' ) ); ?>" type="number" value="<?php echo esc_attr( $eventid ); ?>" size="3" /></p>

		<p>
		<label for="<?php echo $this->get_field_id('showcontent'); ?>"><?php _e( 'Show Content:', 'tokopress' ); ?></label>
		<select name="<?php echo $this->get_field_name('showcontent'); ?>" id="<?php echo $this->get_field_id('showcontent'); ?>">
			<option value="no"<?php selected( $showcontent, 'no' ); ?>><?php _e( 'No', 'tokopress' ); ?></option>
			<option value="excerpt"<?php selected( $showcontent, 'excerpt' ); ?>><?php _e( 'Excerpt / Summary', 'tokopress' ); ?></option>
			<option value="full"<?php selected( $showcontent, 'full' ); ?>><?php _e( 'Full Content', 'tokopress' ); ?></option>
		</select>
		</p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'buttontext' ) ); ?>"><?php _e( 'Button Text:', 'tokopress' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'buttontext' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'buttontext' ) ); ?>" type="text" value="<?php echo esc_attr( $buttontext ); ?>" /></p>

<?php
	}
}
