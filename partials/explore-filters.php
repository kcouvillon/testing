<nav class="explore-filters ws-container">

	<!-- <p class="search-by">Search by</p> -->
	
	<ul class="current-filters list-unstyled clearfix">
		<li class="interests-filters"></li>
		<li class="traveler-filters"></li>
		<li class="destination-filters"></li>
	</ul>
	
	<ul class="filter-menus list-unstyled clearfix">

		<?php ////////////////////////////////////////////////////////////////// ?>

		<li class="filter-menu interests-menu">
			<div class="interests-filters hide-sm"></div>

			<?php $interests = get_terms( 'filter', array( 'parent' => 11 ) ); ?>

			<ul id="interests-parent" class="interests-parent terms-list list-unstyled clearfix">
				
				<?php foreach ( $interests as $interest ) : ?>
				<li><a href="#<?php echo $interest->slug; ?>" class="term-list-toggle parent-term parent-interest"><?php echo $interest->name; ?></a></li>
				<?php endforeach; ?>

			</ul>

			<?php foreach ( $interests as $interest ) : ?>
				
				<ul id="<?php echo $interest->slug; ?>" class="interests-child terms-list list-unstyled clearfix hidden">
					<?php 
					$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id) ); 
					foreach ( $child_interests as $child_interest ) : ?>

					<li><a href="#<?php echo $child_interest->slug; ?>" class="filter" data-filter-list=".interests-filters"><?php echo $child_interest->name; ?></a></li>
					
					<?php endforeach; ?>
					<a href="#interests-parent" class="term-list-toggle">« Back to Interests</a>
				</ul>

			<?php endforeach; ?>

			<i class="icon icon-arrow-down"></i>
		</li>


		<?php ////////////////////////////////////////////////////////////////// ?>

		<li class="filter-menu traveler-menu">
			<div class="traveler-filters hide-sm"></div>
			<ul class="terms-list list-unstyled clearfix">

				<?php $terms = get_terms( 'filter', array( 'child_of' => 222 ) ); ?>
				<?php foreach ( $terms as $term ) : ?>
				<li><a href="#<?php echo $term->slug; ?>" class="filter" data-filter-list=".traveler-filters"><?php echo $term->name; ?></a></li>
				<?php endforeach; ?>

			</ul>
			<i class="icon icon-arrow-down"></i>
		</li>

		
		<?php ////////////////////////////////////////////////////////////////// ?>

		<li class="filter-menu destination-menu">
			<div class="destination-filters hide-sm"></div>
			
			<?php $continents = get_terms( 'filter', array( 'parent' => 6 ) ); ?>

			<ul id="destinations-parent" class="destinations-parent terms-list list-unstyled clearfix">
				<li class="destination-map">
					<span class="destination-graphic"></span>
				</li>
				<li class="terms">
					<ul class="list-unstyled clearfix">
						<?php foreach ( $continents as $continent ) : ?>

						<li><a href="#<?php echo $continent->slug; ?>" class="term-list-toggle parent-term parent-destination"><?php echo $continent->name; ?></a></li>

						<?php endforeach; ?>
					</ul>
				</li>
			</ul>

			<?php foreach ( $continents as $continent ) : ?>
				
				<ul id="<?php echo $continent->slug; ?>" class="destinations-child terms-list list-unstyled clearfix hidden">
					<li class="destination-map">
						<?php echo $continent->name; ?>
						<span class="destination-graphic"></span>
					</li>
					<li class="terms">
						<ul class="list-unstyled clearfix">
							<?php $destinations = get_terms( 'filter', array( 'parent' => $continent->term_id) ); 
							foreach ( $destinations as $destination ) : ?>

							<li><a href="#<?php echo $destination->slug; ?>" class="filter" data-filter-list=".destination-filters"><?php echo $destination->name; ?></a></li>
							
							<?php endforeach; ?>
						</ul>
					</li>
					<a href="#destinations-parent" class="term-list-toggle">« Back to Destinations</a>
				</ul>

			<?php endforeach; ?>

			<i class="icon icon-arrow-down"></i>
		</li>

	</ul>
</nav>