<?php
global $tp_post_classes;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-list ' . $tp_post_classes ); ?>>
	
	<div class="inner-loop">
		<?php if( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'blog-thumbnail' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/img/thumb-venue.png" alt="<?php the_title(); ?>" class="no-thumb">
				</a>
			</div>
		<?php endif; ?>

		<div class="post-inner">
		    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-title"><h2><?php the_title(); ?></h2></a>
		</div>
	</div>

</article>