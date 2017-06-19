<?php

if ( of_get_option( 'tokopress_events_hide_single_gallery' ) )
	return;

global $post;
$gallery_image = get_post_meta( $post->ID, '_format_gallery_ids', true );
$attachments = array_filter( explode( ',', $gallery_image ) );

if ( empty( $attachments ) )
	return;

$gallery_title = of_get_option( 'tokopress_events_custom_gallery_title' );
if ( !trim($gallery_title) ) {
	$gallery_title = __( 'Event Gallery', 'tokopress' );
} 

?>

<div class="event-gallery-wrap">
	<div class="event-gallery-title">
		<h2><?php echo esc_html( $gallery_title ); ?></h2>
	</div>

	<div class="event-gallery-images">
		<div class="row">
			<?php foreach ( $attachments as $attachment_id ) : ?>
				<?php
				$image_link = wp_get_attachment_url( $attachment_id );
				$image_title = esc_attr( get_the_title( $attachment_id ) );
				?>
				<div class="gallery-image col-md-2 col-xs-3">
					<a href="<?php echo esc_url( $image_link ) ?>" title="<?php echo esc_attr( $image_title ); ?>" >
						<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>
