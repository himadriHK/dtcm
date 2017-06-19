<section id="page-title" class="page-title">
	<div class="container">
		<?php tokopress_breadcrumb_event(); ?>
		<?php if ( is_single() ) : ?>
			<h1><?php the_title() ?></h1>
		<?php else : ?>
			<?php if ( of_get_option('tokopress_events_custom_catalog_title') ) : ?>
				<h1><?php echo of_get_option('tokopress_events_custom_catalog_title'); ?></h1>
			<?php elseif ( of_get_option('tokopress_events_label_plural') ) : ?>
				<h1><?php echo of_get_option('tokopress_events_label_plural'); ?></h1>
			<?php else : ?>
				<h1><?php _e( 'Events', 'tokopress' ); ?></h1>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
