<?php
/**
 * PowerReviews Includes
 */

$powerreviews_pairs = array(
array( 'uri' =>	"/collections/smithsonian-university-travel-programs/",		'pr_page_id' =>	'smithsonian-university-travel-programs' ),
array( 'uri' =>	"/collections/reliving-us-history/",						'pr_page_id' =>	'history-themed-programs' ),
array( 'uri' =>	"/collections/science-discoveries/",						'pr_page_id' =>	'science-themed-programs' ),
array( 'uri' =>	"/collections/american-performing-tours/",					'pr_page_id' =>	'american-performing-tours' ),
array( 'uri' =>	"/collections/dance-and-cheer-programs/",					'pr_page_id' =>	'bowl-games-parades-dance' ),
array( 'uri' =>	"/collections/marching-band-programs/",						'pr_page_id' =>	'bowl-games-parades-marching-band' ),
array( 'uri' =>	"/collections/career-focused-programs/",					'pr_page_id' =>	'career-focused-programs' ),
array( 'uri' =>	"/collections/faith-based-concert-tours/",					'pr_page_id' =>	'faith-based-concert-tours' ),
array( 'uri' =>	"/collections/festival-at-carnegie-hall/",					'pr_page_id' =>	'festival-carnegie-hall-elite-performing' ),
array( 'uri' =>	"/collections/festival-of-gold/",							'pr_page_id' =>	'festival-gold-elite-performing' ),
array( 'uri' =>	"/collections/heritage-festivals/",							'pr_page_id' =>	'heritage-festivals' ),
array( 'uri' =>	"/collections/international-concert-tours/",				'pr_page_id' =>	'international-concert-tours' ),
array( 'uri' =>	"/collections/perspectives-on-central-and-eastern-europe/",	'pr_page_id' =>	'central-and-eastern-europe' ),
array( 'uri' =>	"/collections/italian-and-greek-influence/",				'pr_page_id' =>	'italy-and-greece' ),
array( 'uri' =>	"/collections/a-european-perspective/",						'pr_page_id' =>	'multiple-european-countries' ),
array( 'uri' =>	"/collections/french-and-spanish-influence/",				'pr_page_id' =>	'spain-and-france' ),
array( 'uri' =>	"/collections/focus-on-the-americas/",						'pr_page_id' =>	'americas' ),
array( 'uri' =>	"/collections/a-uk-perspective/",							'pr_page_id' =>	'britain-and-ireland' ),
array( 'uri' =>	"/collections/discover-colonial-history/",					'pr_page_id' =>	'discover-colonial-history' ),
array( 'uri' =>	"/collections/florida-science-discovery/",					'pr_page_id' =>	'florida-science-discovery' ),
array( 'uri' =>	"/collections/costa-rica-science-discovery/",				'pr_page_id' =>	'costa-rica-science-discovery' ),
array( 'uri' =>	"/collections/california-history-discovery/",				'pr_page_id' =>	'california-history-discovery' ),
array( 'uri' =>	"/collections/new-york-history-discovery/",					'pr_page_id' =>	'new-york-history-discovery' ),
array( 'uri' =>	"/collections/illinois-history-discovery/",					'pr_page_id' =>	'illinois-history-discovery' ),
array( 'uri' =>	"/collections/a-focus-on-christian-travel/",				'pr_page_id' =>	'a-focus-on-christian-travel' ),
array( 'uri' =>	"/collections/discover-washington-d-c/",					'pr_page_id' =>	'washington-dc-programs' )
);

// print_r($powerreviews_pairs);
// print_r($powerreviews_pairs[15]);
// echo '<br>';
// print_r($powerreviews_pairs[15]['uri']);

$current_url = $_SERVER["REQUEST_URI"];
$pr_page_id  = '';

foreach ( $powerreviews_pairs as $powerreviews_pair ) {
	if( $current_url === $powerreviews_pair['uri'] ) {
		$pr_page_id = $powerreviews_pair['pr_page_id'];
	}
}

$display_title = get_post_meta( $post->ID, 'general_display_title', true );
if ( ! $display_title ) {
	$display_title = get_the_title();
}


// echo do_shortcode('[powerreviews pr_page_id="' . $pr_page_id . '"]');
echo WS_PowerReviews::html_from_pr_page_id( $pr_page_id, apply_filters( 'the_title', $display_title ) ); 