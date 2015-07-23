<nav class="explore-filters ws-container">

	<!-- <p class="search-by">Search by</p> -->
	
	<ul class="current-filters list-unstyled clearfix">
		<li class="interests-filters">Interests</li>
		<li class="traveler-filters">Traveler</li>
		<li class="destination-filters">Destination</li>
	</ul>
	
	<ul class="filter-menus list-unstyled clearfix">

		<li class="filter-menu interests-menu">
			<div class="interests-filters hide-sm">Interests <span class="icon icon-arrow-down"></span></div>
			<ul class="terms-list list-unstyled clearfix">
				
				<?php $terms = get_terms( 'filter', array( 'child_of' => 11 ) ); ?>
				<?php foreach ( $terms as $term ) : ?>
				<li><a href="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
				<?php endforeach; ?>

			</ul>
		</li>

		<li class="filter-menu traveler-menu">
			<div class="traveler-filters hide-sm">Traveler <span class="icon icon-arrow-down"></span></div>
			<ul class="terms-list list-unstyled clearfix">

				<?php $terms = get_terms( 'filter', array( 'child_of' => 222 ) ); ?>
				<?php foreach ( $terms as $term ) : ?>
				<li><a href="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
				<?php endforeach; ?>

			</ul>
		</li>

		<li class="filter-menu destination-menu">
			<div class="destination-filters hide-sm">Destination <span class="icon icon-arrow-down"></span></div>
			
			<?php $continents = get_terms( 'filter', array( 'parent' => 6 ) ); ?>

			<ul class="distinations-global list-unstyled clearfix">
				<li class="destination-map">
					<?php echo $continent->name; ?>
					<span class="destination-graphic"></span>
				</li>
				<li class="terms">
					<ul class="terms-list list-unstyled clearfix">
						<?php foreach ( $continents as $continent ) : ?>

						<li><a href="#<?php echo $continent->slug; ?>"><?php echo $continent->name; ?></a></li>

						<?php endforeach; ?>
					</ul>
				</li>
			</ul>

			<?php foreach ( $continents as $continent ) : ?>
				
				<ul class="destinations-continental list-unstyled clearfix">
					<li class="destination-map">
						<?php echo $continent->name; ?>
						<span class="destination-graphic"></span>
					</li>
					<li class="terms">
						<ul class="terms-list list-unstyled clearfix">
							<?php $destinations = get_terms( 'filter', array( 'parent' => $continent->term_id) ); 
							foreach ( $destinations as $destination ) : ?>

							<li><a href="#"><?php echo $destination->name; ?></a></li>
							
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>

			<?php endforeach; ?>
		</li>

	</ul>
</nav>