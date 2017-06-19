<?php
/**
 * Tokopress Event Organizers
 *
 * @package Events
 * @author Tokopress
 *
 */

add_shortcode( 'eventica_event_organizers', 'eventica_shortcode_event_organizers' );
function eventica_shortcode_event_organizers( $atts ) {

	if( ! class_exists( 'Tribe__Events__Main' ) )
		return;

	extract( shortcode_atts( array(
		'exclude'			=> '',
		'numbers'			=> 30,
		'columns'			=> 3,
		'columns_tablet'	=> 2,
		'title_hide'		=> 'no',
		'title_text'		=> '',
		'title_color'		=> '',
	), $atts ) );

	$numbers = intval( $numbers );
	if ( $numbers < 1 )
		$numbers = 3;

	$columns = intval( $columns );
	if ( $columns < 1 )
		$columns = 1;
	if ( $columns > 3 )
		$columns = 3;

	$columns_tablet = intval( $columns_tablet );
	if ( $columns_tablet < 1 )
		$columns_tablet = 1;
	if ( $columns_tablet > 2 )
		$columns_tablet = 2;

	$columns_style = 'col-md-'.intval(12/$columns).' col-sm-'.intval(12/$columns_tablet);

	if ( !trim($title_text) )
		$title_text = __( 'Event Organizers', 'tokopress' );

	$title_style = trim( $title_color ) ? 'style="color:'.$title_color.'"' : '';

	ob_start();

	$args = array(
		'post_type'			=> 'tribe_organizer',
		'posts_per_page'	=> $numbers,
		'orderby'        	=> 'name',
		'order'          	=> 'ASC',
		);

	if ( ! empty( $exclude ) ) {
		$ids = explode( ",", $exclude );
		$args['post__not_in'] = $ids;
	}

	$the_event_organizers = new WP_Query( $args );

	if( $the_event_organizers->have_posts() ) :
	?>
	<div class="home-recent-posts">

		<div class="recent-post-wrap">

			<?php if ( $title_hide != 'yes' ) : ?>
				<h2 class="recent-post-title" <?php echo $title_style; ?>>
					<?php echo $title_text; ?>
				</h2>
			<?php endif; ?>

			<div class="row">
				<?php while ( $the_event_organizers->have_posts() ) : ?>
					<?php $the_event_organizers->the_post(); ?>

						<?php
						global $tp_post_classes;
						$tp_post_classes = $columns_style;
						?>
						<?php get_template_part( 'content', 'tribe_organizer' ); ?>
							
				<?php endwhile; ?>
			</div>

		</div>

	</div>

	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<?php $output = ob_get_clean(); ?>

	<?php
	return $output;
}

add_action( 'vc_before_init', 'eventica_vc_event_organizers' );
function eventica_vc_event_organizers() {

	vc_map( array(
	   'name'				=> __( 'Eventica - Event Organizers', 'tokopress' ),
	   'base'				=> 'eventica_event_organizers',
	   'class'				=> '',
	   'icon'				=> '',
	   'category'			=> 'Eventica',
	   'admin_enqueue_js' 	=> '',
	   'admin_enqueue_css' 	=> '',
	   'params'				=> array(
	   							array(
									'type'			=> 'textfield',
									'heading'		=> __( 'Number Of Organizers', 'tokopress' ),
									'param_name'	=> 'numbers',
									'std'			=> '30',
									'value'			=> '',
								),
	   							array(
									'type'			=> 'textfield',
									'heading'		=> __( 'Exclude', 'tokopress' ),
									'param_name'	=> 'exclude',
									'description'	=> __( 'Insert Organizer IDs (separated by comma) to exclude.', 'tokopress' ),
									'std'			=> '',
									'value'			=> '',
								),
								array(
									'type'			=> 'dropdown',
									'heading'		=> __( 'Number of Columns in Desktop', 'tokopress' ),
									'param_name'	=> 'columns',
									'std'			=> '',
									'value'			=> array(
														'' => '',
														'3' => '3',
														'2' => '2',
														'1' => '1',
													),
									'description' 	=> __( 'For device width >= 992px', 'tokopress' ),
								),
								array(
									'type'			=> 'dropdown',
									'heading'		=> __( 'Number of Columns in Tablet', 'tokopress' ),
									'param_name'	=> 'columns_tablet',
									'std'			=> '',
									'value'			=> array(
														'' => '',
														'2' => '2',
														'1' => '1',
													),
									'description' 	=> __( 'For device width >= 768px and < 992px', 'tokopress' ),
								),
								array(
									'type'			=> 'dropdown',
									'heading'		=> __( 'Hide Section Title', 'tokopress' ),
									'param_name'	=> 'title_hide',
									'value'			=> array(
														__( 'No', 'tokopress' ) => 'no',
														__( 'Yes', 'tokopress' ) => 'yes',
													),
								),
								array(
									'type'			=> 'textfield',
									'heading'		=> __( 'Section Title Text', 'tokopress' ),
									'description'	=> __( 'Default:', 'tokopress' ).' '.__( 'Event Organizers', 'tokopress' ),
									'param_name'	=> 'title_text',
									'value'			=> ''
								),
								array(
									'type' 			=> 'colorpicker',
									'heading' 		=> __( 'Section Title Color', 'tokopress' ),
									'param_name' 	=> 'title_color',
									'description' 	=> __( 'Select text color for section title.', 'tokopress' )
								),
							)
	   )
	);
}
