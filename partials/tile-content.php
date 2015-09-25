
<a href="<?php echo esc_url( $url ); ?>">
	<div class="tile-content">
		
		<?php if ( !empty( $meta_list ) ) : ?>
		<ul class="meta list-unstyled">

			<?php foreach( $meta_list as $meta ) : ?>
				<?php if ( $meta['url'] ) : ?>

				<li><a href="<?php echo esc_url( $meta['url'] ); ?>"><?php echo $meta['name']; ?></a></li>
				
				<?php else : ?>

				<li class="list-tag-no-link"><?php echo $meta['name']; ?></li>	
				
				<?php endif; ?>
			<?php endforeach; ?>

		</ul>
		<?php endif; ?>

		<?php if ( is_page('explore') && $show_smithsonian ) : ?>
			<img class="smithsonian-image" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small.png' ); ?>" />
			<img class="smithsonian-image-mobile" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small-gray.png' ); ?>" />
		<?php elseif ( $show_smithsonian ) : ?>
			<img class="smithsonian-image" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small.png' ); ?>" />
		<?php endif; ?>
		
		<h3 class="h2 tile-title"><?php echo $title; ?></h2>

	</div>
</a>

<?php //include( locate_template( 'partials/tile-content.php' ) ); ?>