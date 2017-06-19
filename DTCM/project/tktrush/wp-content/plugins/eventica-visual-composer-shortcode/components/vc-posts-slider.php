<?php
/**
 * Tokopress Slider Posts
 *
 * @package Posts
 * @author Tokopress
 *
 */

add_shortcode( 'eventica_posts_slider', 'eventica_shortcode_posts_slider' );
function eventica_shortcode_posts_slider( $atts ) {

	extract( shortcode_atts( array(
		'category' => '',
		'ids' => '',
		'numbers' => 4,
		'button' => '',
		'columns' => '',
		'container' => 'no',
		'detail_bg_color' => '',
		'detail_text_color' => '',
	), 
	$atts ) );

	if ( !trim($button) )
		$button = __( 'Detail', 'tokopress' );

	$numbers = intval( $numbers );
	if ( $numbers < 1 )
		$numbers = 4;

	$detail_style = '';
	$link_style = '';
	if ( $detail_bg_color ) {
		$detail_style .= 'background-color:'.$detail_bg_color.';';
	}
	if ( $detail_text_color ) {
		$detail_style .= 'color:'.$detail_text_color.';';
		$link_style .= 'color:'.$detail_text_color.';';
		$link_style .= 'border-color:'.$detail_text_color.';';
	}
	if ( $detail_style ) {
		$detail_style = 'style="'.$detail_style.'"';
	}
	if ( $link_style ) {
		$link_style = 'style="'.$link_style.'"';
	}

	$args = array(
		'post_status'	=>'publish',
		'post_type'		=>'post',
		);
	if ( ! empty( $ids ) ) {
		$ids = explode( ",", $ids );
		$args['post__in'] = $ids;
		$args['orderby'] = 'post__in';
		$args['order'] = 'ASC';

		$the_slider_posts = new WP_Query( $args );

		if( $the_slider_posts->have_posts() ) {
			$reorder_loop = array();
			foreach($ids as $rpid) {
				foreach($the_slider_posts->posts as $index => $fpid) {
					if($fpid->ID == $rpid) {
						$reorder_loop[] = $the_slider_posts->posts[$index];
					}
				}
			}
			$the_slider_posts->posts = $reorder_loop;
		}
	}
	else {
		$args['posts_per_page'] = $numbers;
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';

		if ( $category ) {
			$term = term_exists( $category, 'category' );
			if ($term !== 0 && $term !== null) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => array( $term['term_id'] ),
						'operator' => 'IN'
					)
				);
			}
			else {
				return '<p">'.sprintf( __('"%s" post category does not exist.', 'tokopress'), $category ).'</p>';
			}
		}

		$the_slider_posts = new WP_Query( $args );
	}

	$output = '';
	if( $the_slider_posts->have_posts() ) :
		$class = $the_slider_posts->post_count > 1 ? 'home-slider-events-active' : '';
		$output .= '<div class="home-slider-events clearfix '.esc_attr( $class ).'">';
		while ( $the_slider_posts->have_posts() ) :
			$the_slider_posts->the_post();
			$img = wp_get_attachment_url( get_post_thumbnail_id($the_slider_posts->post->ID), 'full' );
			if ( $img ) :
				$output .= '<div class="slide-event item" style="background-image:url('.esc_url($img).')">';
			else : 
				$output .= '<div class="slide-event item">';
			endif;
				if ( $container == 'yes' ) {
					$output .= '<div class="container">';
				}
				$output .= '<div class="row">';
				if ( intval($columns) > 12 ) 
					$columns = 12;
				if ( intval($columns) > 0 ) {
					$output .= '<div class="col-sm-'.intval($columns).'">';
				}
				else {
					$output .= '<div class="col-sm-6 col-md-5 col-lg-4">';
				}
				$output .= '<div class="slide-event-detail" '.$detail_style.'>';
					$output .= '<h2 class="slide-event-title">';
						$output .= '<a class="url" href="'.get_permalink().'" rel="bookmark" '.$link_style.'>';
							$output .= get_the_title();
						$output .= '</a>';
					$output .= '</h2>';
					$output .= '<div class="slide-event-cta">';
						$output .= get_the_excerpt();
					$output .= '</div>';
					$output .= '<div class="slide-event-datetime">';
						$output .= '<div class="slide-event-datetime-details">';
							$output .= tokopress_get_post_date();
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				if ( $container == 'yes' ) {
					$output .= '</div>';
				}
			$output .= '</div>';
		endwhile;
		$output .= '</div>';
		if ( $the_slider_posts->post_count > 1 ) {
			wp_enqueue_script( 'tokopress-owl-js' );
		}
	endif;
	wp_reset_postdata();

	return $output;
}

add_action( 'vc_before_init', 'eventica_vc_posts_slider' );
function eventica_vc_posts_slider() {
	vc_map( array(
	   'name'				=> __( 'Eventica - Posts Slider', 'tokopress' ),
	   'base'				=> 'eventica_posts_slider',
	   'class'				=> '',
	   'icon'				=> '',
	   'category'			=> 'Eventica',
	   'admin_enqueue_js' 	=> '',
	   'admin_enqueue_css' 	=> '',
	   'params'				=> array(
									array(
										'type'			=> 'textfield',
										'heading'		=> __( 'Post IDs', 'tokopress' ),
										'param_name'	=> 'ids',
										'value'			=> '',
										'description' 	=> __( 'Separated by comma. Use this is you want to show some specific posts. "Number of Posts" and "Post Category" options will be ignored.', 'tokopress' ),
									),
									array(
										'type'			=> 'dropdown',
										'heading'		=> __( 'Number of Posts', 'tokopress' ),
										'param_name'	=> 'numbers',
										'value'			=> array(
															''		=> '',
															'1'		=> '1',
															'2'		=> '2',
															'3'		=> '3',
															'4'		=> '4',
															'5'		=> '5',
															'6'		=> '6',
															'7'		=> '7',
															'8'		=> '8',
															'9'		=> '9',
															'10'	=> '10',
														),
										'description' 	=> __( 'Use this is you want to show recent posts. Leave "Post IDs" option empty.', 'tokopress' ),
									),
		   							array(
										'type'			=> 'textfield',
										'heading'		=> __( 'Post Category Name', 'tokopress' ),
										'param_name'	=> 'category',
										'description'	=> __( 'Put post category name here if you want to retrieve upcoming posts from this category only. Leave "Post IDs" option empty.', 'tokopress' ),
										'std'			=> '',
										'value'			=> '',
									),
									array(
										'type'			=> 'dropdown',
										'heading'		=> __( 'Container', 'tokopress' ),
										'param_name'	=> 'container',
										'value'			=> array(
															__( 'No', 'tokopress' ) => 'no',
															__( 'Yes', 'tokopress' ) => 'yes',
														),
										'description' 	=> __( 'Use yes if you use "Strecth Row" option on Visual Composer row.', 'tokopress' ),
									),
									array(
										'type'			=> 'dropdown',
										'heading'		=> __( 'Custom Column Size for Post Detail', 'tokopress' ),
										'param_name'	=> 'columns',
										'value'			=> array(
															__( 'default', 'tokopress' ) => '',
															'col-3 (3/12)' => '3',
															'col-4 (4/12)' => '4',
															'col-5 (5/12)' => '5',
															'col-6 (6/12)' => '6',
															'col-7 (7/12)' => '7',
															'col-8 (8/12)' => '8',
															'col-9 (9/12)' => '9',
															'col-10 (10/12)' => '10',
															'col-10 (11/12)' => '11',
															'col-10 (12/12)' => '12',
														),
										'description' 	=> __( 'Use this is you want to use custom column size (in 12 grid) for post detail box.', 'tokopress' ),
									),
									array(
										'type' => 'colorpicker',
										'heading' => __( 'Post Details Background Color', 'tokopress' ),
										'param_name' => 'detail_bg_color',
										'description' => __( 'Select background color for post detail box.', 'tokopress' )
									),
									array(
										'type' => 'colorpicker',
										'heading' => __( 'Post Details Text Color', 'tokopress' ),
										'param_name' => 'detail_text_color',
										'description' => __( 'Select text color for post detail box.', 'tokopress' )
									),
								)
	   )
	);
}