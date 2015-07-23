<section class="explore-results section-content">

	<div class="collections">
		<header class="results-header">
			<h2>Collections</h2>
			<a href="#" class="see-more">See more</a>
		</header>
		<div class="results clearfix">

			<article ng-repeat="(key, collection) in collections"
					 class="{{collection.type}} {{collection.slug}} tile tile-third {{ (key > 2) ? 'hidden' : '' }}"
					 style="background-image:url(http://localhost/worldstrides/wp-content/themes/worldstrides/assets/images/src/patterns/ws_w_pattern{{ (key % 2 == 0) ? '5' : '8' }}.gif);" >

				<div class="tile-content collection-content">
					<ul class="meta collection-meta list-unstyled">
						<li><a href="#">High School</a></li>
					</ul>
					<h2 class="tile-title collection-title"><a href="{{collection.link}}">{{ collection.title.rendered }}</a></h2>
				</div>

			</article>

		</div>
	</div>

	<div class="itineraries">
		<header class="results-header">
			<h2>Itineraries</h2>
		</header>
		<div class="results clearfix">
			
			<article ng-repeat="(key, itinerary) in itineraries"
					 class="{{itinerary.type}} {{itinerary.slug}} tile tile-third"
					 style="background-image:url(http://localhost/worldstrides/wp-content/themes/worldstrides/assets/images/src/patterns/ws_w_pattern{{ (key % 2 == 0) ? '1' : '2' }}.gif);" >

				<div class="tile-content itinerary-content">
					<ul class="meta itinerary-meta list-unstyled">
						<li><a href="#">High School</a></li>
					</ul>
					<h2 class="tile-title itinerary-title"><a href="{{itinerary.link}}">{{ itinerary.title.rendered }}</a></h2>
				</div>

			</article>

		</div>
	</div>

</section>