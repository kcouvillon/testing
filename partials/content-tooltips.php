<?php
$tooltip_top = get_post_meta( $post->ID, 'hero_tooltips_title_right_top', true );
$tooltip_top_caption = get_post_meta( $post->ID, 'hero_tooltips_caption_right_top', true );
$tooltip_middle = get_post_meta( $post->ID, 'hero_tooltips_title_right_middle', true );
$tooltip_middle_caption = get_post_meta( $post->ID, 'hero_tooltips_caption_right_middle', true );
$tooltip_bottom = get_post_meta( $post->ID, 'hero_tooltips_title_right_bottom', true );
$tooltip_bottom_caption = get_post_meta( $post->ID, 'hero_tooltips_caption_right_bottom', true );
?>

<ul class="ws-tooltips list-unstyled">
	<?php if( ! empty( $tooltip_top ) ) : ?>
		<li class="ws-tooltip ws-tooltip-1" style="left: <?php echo rand(35, 50); ?>%;">
			<div class="ws-tooltip-content">
				<span class="small"><?php echo $tooltip_top; ?></span><br>
				<?php echo $tooltip_top_caption; ?>
			</div>
		</li>
	<?php endif; ?>

	<?php if( ! empty( $tooltip_middle ) ) : ?>
		<li class="ws-tooltip ws-tooltip-2" style="left: <?php echo rand(35, 50); ?>%;">
			<div class="ws-tooltip-content">
				<span class="small"><?php echo $tooltip_middle; ?></span><br>
				<?php echo $tooltip_middle_caption; ?>
			</div>
		</li>
	<?php endif; ?>

	<?php if( ! empty( $tooltip_bottom ) ) : ?>
		<li class="ws-tooltip ws-tooltip-3" style="left: <?php echo rand(35, 50); ?>%;">
			<div class="ws-tooltip-content">
				<span class="small"><?php echo $tooltip_bottom; ?></span><br>
				<?php echo $tooltip_bottom_caption; ?>
			</div>
		</li>
	<?php endif; ?>
</ul>
