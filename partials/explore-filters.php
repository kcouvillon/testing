<?php 

$interestsArgs = array( 
	'parent' => 11, // Interest
	'orderby' => 'term_order', 
	'hide_empty' => false,
	'exclude' => 384 // Faith Based & Service
	);
$travelersArgs = array( 
	'parent' => 222, // Traveler
	'orderby' => 'term_order', 
	'hide_empty' => false
	);
$continentsArgs = array( 
	'parent' => 498, // Destination
	'orderby' => 'term_order', 
	'hide_empty' => false
	);
$travelers  = get_terms( 'filter', $travelersArgs );
$interests  = get_terms( 'filter', $interestsArgs ); 
$continents = get_terms( 'filter', $continentsArgs );

?>

<nav class="explore-filters">

	<div class="ws-container">
	
		<ul class="current-filters list-unstyled clearfix">
			<li class="traveler-filters"></li>
			<li class="interests-filters"></li>
			<li class="destination-filters"></li>
		</ul>
		
		<ul class="filter-menus open list-unstyled clearfix">

			<?php ////////////////////////////////////////////////////////////////// ?>

			<li class="filter-menu traveler-menu">
				<div class="traveler-filters hide-sm toggle" data-target=".traveler-menu-container"></div>

				<div class="traveler-menu-container menu-container closed">
					<ul class="terms-list list-unstyled clearfix">

						<?php foreach ( $travelers as $traveler ) : ?>
						<li><a href="#<?php echo $traveler->slug; ?>" class="filter" data-filter-list=".traveler-filters"><?php echo $traveler->name; ?></a></li>
						<?php endforeach; ?>

					</ul>
				</div>

				<span class="arrow icon-arrow-down hide-sm"></span>
			</li>

			<?php ////////////////////////////////////////////////////////////////// ?>

			<li class="filter-menu interests-menu">
				<div class="interests-filters toggle hide-sm" data-target=".interests-menu-container"></div>

				<div class="interests-menu-container menu-container closed">

					<ul id="interests-parent" class="interests-parent terms-list-parent terms-list list-unstyled clearfix">
						
						<?php foreach ( $interests as $interest ) : ?>
						<li><a href="#<?php echo $interest->slug; ?>" class="term-list-toggle parent-term parent-interest">
							<i class="icon icon-<?php echo $interest->slug; ?>"></i>
							<?php echo $interest->name; ?>
							<i class="icon icon-arrow-right"></i>
							</a></li>
						<?php endforeach; ?>

						<li>
							<a href="#faith-based" class="filter" data-filter-list=".interests-filters">
								<i class="icon icon-faith-based"></i>
								Faith-based
							</a>
						</li>

						<li>
							<a href="#service" class="filter" data-filter-list=".interests-filters">
								<i class="icon icon-service"></i>
								Service
							</a>
						</li>

					</ul>

					<?php foreach ( $interests as $interest ) : ?>
						
						<ul id="<?php echo $interest->slug; ?>" class="interests-child terms-list-child terms-list list-unstyled clearfix invisible">
							
							<li class="parent-term"><a class="parent-interest">
								<i class="icon icon-<?php echo $interest->slug; ?>"></i>
								<?php echo $interest->name; ?></a>
							</li>

							<?php 
							$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id ) ); 
							foreach ( $child_interests as $child_interest ) : ?>

							<li><a href="#<?php echo $child_interest->slug; ?>" class="filter" data-filter-list=".interests-filters"><?php echo $child_interest->name; ?></a></li>
							
							<?php endforeach; ?>
							<a href="#interests-parent" class="term-list-toggle">« Back to Interests</a>
						</ul>

					<?php endforeach; ?>

				</div>

				<span class="arrow icon-arrow-down hide-sm"></span>
			</li>
			
			<?php ////////////////////////////////////////////////////////////////// ?>

			<li class="filter-menu destination-menu">
				<div class="destination-filters toggle hide-sm" data-target=".destination-menu-container"></div>
				
				<div class="destination-menu-container menu-container closed">

					<ul id="destinations-parent" class="destinations-parent terms-list-parent terms-list list-unstyled clearfix">
						<li class="destination-map">
							<span class="destination-graphic">
								<img src="<?php echo get_template_directory_uri() . '/assets/images/map-global.png'; ?>" alt="Global"/>
							</span>
						</li>
						<li>
							<ul class="terms list-unstyled clearfix">
								<?php foreach ( $continents as $continent ) : ?>

								<li><a href="#<?php echo $continent->slug; ?>" class="filter term-list-toggle parent-term parent-destination" data-filter-list=".destination-filters"><?php echo $continent->name; ?></a></li>

								<?php endforeach; ?>
							</ul>
						</li>
					</ul>

					<?php foreach ( $continents as $continent ) : ?>
						
						<ul id="<?php echo $continent->slug; ?>" class="destinations-child terms-list-child terms-list list-unstyled clearfix invisible">
							<li class="destination-map">
								<?php echo $continent->name; ?>
								<span class="destination-graphic">
									<img src="<?php echo get_template_directory_uri() . '/assets/images/map-' . $continent->slug . '.png'; ?>" alt="<?php echo $continent->name; ?>"/>
								</span>
							</li>
							<li>
								<ul class="terms list-unstyled clearfix">
									<?php $destinations = get_terms( 'filter', array( 'parent' => $continent->term_id ) ); 
									foreach ( $destinations as $destination ) : ?>

									<li><a href="#<?php echo $destination->slug; ?>" class="filter" data-filter-list=".destination-filters"><?php echo $destination->name; ?></a></li>
									
									<?php endforeach; ?>
								</ul>
							</li>
							<a href="#destinations-parent" class="term-list-toggle">« Back to Destinations</a>
						</ul>

					<?php endforeach; ?>

				</div>

				<span class="arrow icon-arrow-down hide-sm"></span>
			</li>

		</ul>

	</div>

</nav>

<!-- <div class="explore-filters-toggle ws-container">
	<a href="#explore-results"><span class="collections-count">Collections</span> and <span class="itineraries-count">Itineraries</span>.</a>
</div> -->



