<?php
/**
 * WorldStrides functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package WorldStrides
 * @since   0.1.0
 */

// Useful global constants
define( 'WS_VERSION', '0.1.0' );
define( 'WS_PATH', dirname( __FILE__ ) . '/' );
define( 'WS_IMAGE_URL', get_template_directory_uri() . '/assets/images/' );

// Disable file edit/mods from within WordPress
define( 'DISALLOW_FILE_EDIT', true ); // turn off edits
// define( 'DISALLOW_FILE_MODS', true ); // turn off all mods (includes plugin updates)

// Helper Libraries (worth checking for updates occasionally
include WS_PATH . 'includes/library-extended-cpts.php';
include WS_PATH . 'includes/library-extended-taxos.php';
include WS_PATH . 'includes/cmb2/init.php';
include WS_PATH . 'includes/cmb2-attached-posts/cmb2-attached-posts-field.php';
include WS_PATH . 'includes/cmb2-maps-google/cmb-field-map.php';
include WS_PATH . 'includes/cmb2-post-search/cmb2-post-search-field.php';
include WS_PATH . 'includes/taxonomy-metadata/Taxonomy_MetaData.php';
include WS_PATH . 'includes/taxonomy-metadata/Taxonomy_MetaData_CMB2.php';

// Theme Includes
include WS_PATH . 'includes/class-associated-filter.php';
include WS_PATH . 'includes/class-admin-options.php';
include WS_PATH . 'includes/class-collections.php';
include WS_PATH . 'includes/class-comments.php';
include WS_PATH . 'includes/class-cpts.php';
include WS_PATH . 'includes/class-explore.php';
include WS_PATH . 'includes/class-form.php';
include WS_PATH . 'includes/class-helpers.php';
include WS_PATH . 'includes/class-marketo.php';
include WS_PATH . 'includes/class-marketo-abstract-authenticate.php';
include WS_PATH . 'includes/class-marketo-associate.php';
include WS_PATH . 'includes/class-marketo-requestcampaign.php';
include WS_PATH . 'includes/class-marketo-upsert.php';
include WS_PATH . 'includes/class-metaboxes.php';
include WS_PATH . 'includes/class-metaboxes-blocks.php';
include WS_PATH . 'includes/class-metaboxes-collections.php';
include WS_PATH . 'includes/class-metaboxes-custom-pages.php';
include WS_PATH . 'includes/class-metaboxes-divisions.php';
include WS_PATH . 'includes/class-metaboxes-itineraries.php';
include WS_PATH . 'includes/class-metaboxes-filter-endpoints.php';
include WS_PATH . 'includes/class-metaboxes-resources.php';
include WS_PATH . 'includes/class-powerreviews.php';
include WS_PATH . 'includes/class-shortcodes.php';
include WS_PATH . 'includes/class-taxos.php';

/**
 * Set up theme defaults and register supported WordPress features.
 */
function ws_setup() {
	load_theme_textdomain( 'ws', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	register_nav_menus( array(
		'primary'        => __( 'Primary Menu', 'worldstrides' ),
		'secondary'      => __( 'Quick Access Menu', 'worldstrides' ),
		'footer'         => __( 'Footer Menu 1', 'worldstrides' ),
		'footer2'        => __( 'Footer Menu 2', 'worldstrides' ),
		'footer3'        => __( 'Footer Menu 3', 'worldstrides' ),
		'footer4'        => __( 'Footer Menu 4', 'worldstrides' ),
		'about'          => __( 'About Menu', 'worldstrides' ),
		'resource-types' => __( 'Resource Type Menu', 'worldstrides' ),
	) );

	add_post_type_support( 'page', 'excerpt' );

	add_image_size( 'hero', 1500 );
	add_image_size( 'square', 1030, 900, true );
	add_image_size( 'itinerary', 1500, 400, true );
	add_image_size( 'tour-highlights', 990, 743, true );

}

add_action( 'after_setup_theme', 'ws_setup' );

/**
 * Enqueue scripts and styles for front-end.
 */
function ws_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	// wp_register_script( 'mixitup', get_template_directory_uri() . '/assets/js/vendor/jquery.mixitup.min.js', array(), WS_VERSION, true );
	wp_register_script( 'angular', get_template_directory_uri() . '/explore/angular.min.js', array(), WS_VERSION, false );
	wp_register_script( 'angular-route', get_template_directory_uri() . '/explore/angular-route.min.js', array(), WS_VERSION, false );
	wp_register_script( 'angular-sanitize', get_template_directory_uri() . '/explore/angular-sanitize.min.js', array(), WS_VERSION, false );
	wp_register_script( 'angular-animate', get_template_directory_uri() . '/explore/angular-animate.min.js', array(), WS_VERSION, false );
	wp_register_script( 'explore', get_template_directory_uri() . '/explore/explore.js', array(), WS_VERSION, true );

	wp_enqueue_script( 'jquery' );

	if ( is_page_template( 'templates/about-offices.php' ) || is_page_template( 'templates/division-capstone.php' ) || is_singular( 'itinerary' ) || is_singular( 'custom-page' ) || is_search() ) {
		wp_enqueue_style( 'mapbox-style', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css', array(), WS_VERSION );
		wp_enqueue_script( 'mapbox', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js', array(), WS_VERSION, true );
	}

	if ( is_singular( 'collection' ) ) {
		wp_enqueue_script( 'mixitup' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}

	if ( is_page_template( 'templates/explore.php' ) ) {
		// wp_enqueue_script( 'mixitup' );
		wp_enqueue_script( 'angular' );
		wp_enqueue_script( 'angular-route' );
		wp_enqueue_script( 'angular-sanitize' );
		wp_enqueue_script( 'angular-animate' );
		wp_enqueue_script( 'explore' );
		wp_localize_script( 'explore',
			'WS',
			array(
				'theme' => get_template_directory_uri(),
				'explore' => get_template_directory_uri() . '/explore',
				'exploreApi' => site_url() . '/ws-api/v1/explore'
			)
		);
	}

	// Custom code to hide the word Protected from protected posts
	if ( is_singular( 'custom-page') ) {
		function the_title_trim($title) {
			$title = esc_attr($title);
			$findthese = array(
				'#Protected:#',
				'#Private:#'
			);
			$replacewith = array(
				'', // What to replace "Protected:" with
				'' // What to replace "Private:" with
			);
			$title = preg_replace($findthese, $replacewith, $title);
			return $title;
		}
		add_filter('the_title', 'the_title_trim');		
	}

	wp_enqueue_script( 'jquery-ui-autocomplete' ); // used on form submissions, available on all pages
	
	if ( !is_page( 'ie-fallback' ) ) {
		wp_enqueue_script( 'ws', get_template_directory_uri() . "/assets/js/worldstrides{$postfix}.js", array( 'jquery' ), WS_VERSION, true );
		wp_enqueue_style( 'ws', get_template_directory_uri() . "/assets/css/worldstrides{$postfix}.css", array(), WS_VERSION );
	}

	wp_localize_script( "ws",
		'worldstrides_ajax',
		array(
			'ajaxUrl' => admin_url( "admin-ajax.php" ), //url for php file that process ajax request to WP
			'nonce' => wp_create_nonce( "worldstrides_ajax_nonce" ), // this is a unique token to prevent form hijacking
		)
	);
}

add_action( 'wp_enqueue_scripts', 'ws_scripts_styles' );

/**
 * Enqueue scripts in the admin area
 */
function ws_admin_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'ws-admin', get_template_directory_uri() . "/assets/css/admin{$postfix}.css", array(), WS_VERSION );
}

add_action( 'admin_enqueue_scripts', 'ws_admin_scripts_styles' );

/**
 * Find a post/page id via slug
 *
 * @param $page_slug
 *
 * @return int|null
 */
function get_id_by_slug( $page_slug ) {
	$page = get_page_by_path( $page_slug );
	if ( $page ) {
		return $page->ID;
	} else {
		return null;
	}
}

/**
 * Add class to body_class if there is a featured image
 *
 * @param $classes
 *
 * @return array original classes plus ones we've added
 */
function ws_add_body_classes( $classes ) {
	global $post;
	$about_id       = get_id_by_slug( 'about' );
	$is_about_child = false;

	if ( $post && $about_id == $post->post_parent ) {
		$is_about_child = true;
	}

	if ( isset ( $post->ID ) && get_the_post_thumbnail( $post->ID ) && ! is_archive() && ! is_home() && ! is_singular( 'press' ) && ! is_page( 'history' ) && ! is_singular( 'bio' ) && ! is_page( 'contact' ) ) {
		$classes[] = 'has-featured-image';

		if ( is_front_page() ) {
			$classesp[] = 'has-featured-image';
		}
	}

	if ( is_archive() || is_home() || is_page( 'about' ) || is_page( 'contact' ) || $is_about_child || is_page( 'resource-center' ) || is_singular( 'resource' ) || is_singular( 'bio' ) || is_404() || is_search() || is_page_template( 'form-page.php' ) ) {
		$classes[] = 'solid-header';

		if ( is_front_page() ) {
			$classes[] = 'transparent-header';
		}
	} else {
		$classes[] = 'transparent-header';
	}

	return $classes;
}
add_filter( 'body_class', 'ws_add_body_classes' );

/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 45;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );


/**
 * Customize ellipsis after the_excerpt
 */
function ws_new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'ws_new_excerpt_more' );


/**
 * Remove cruft from header
 *
 * This could potentially be replaced by Yoast SEO functionality
 */
// remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );

// do autop after shortcode, was necessary for timeline shortcode
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );

/**
 * Remove default custom fields box
 */
function customize_admin_init() {
	remove_meta_box( 'postcustom', 'post', 'normal' );
	remove_post_type_support( 'post', 'comments' );
}
add_action( 'admin_init', 'customize_admin_init' );

/**
 * Modify default areas in specific areas of the site
 *
 * @param $query
 */
function ws_modified_queries( $query ) {
	if ( is_tax( 'resource-target' ) && ! is_admin() ) {
		$query->set( 'posts_per_page', '100' );
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );

		return;
	}
}
add_action( 'pre_get_posts', 'ws_modified_queries', 1 );

/**
 * Set image sizes
 */
function ws_image_sizes() {
	update_option( 'thumbnail_size_w', 270 );
	update_option( 'thumbnail_size_h', 270 );
	update_option( 'thumbnail_crop', 1 );
	update_option( 'medium_size_w', 480 );
	update_option( 'medium_size_h', 480 );
	update_option( 'large_size_w', 1030 );
	update_option( 'large_size_h', 1030 );
}
add_action( 'switch_theme', 'ws_image_sizes' );

/**
 * Add author type field to Co-Authors Plus
 */
function ws_filter_guest_author_fields( $fields_to_return, $groups ) {

	if ( in_array( 'all', $groups ) || in_array( 'name', $groups ) ) {
		$fields_to_return[] = array(
			'key'   => 'author_type',
			'label' => 'Author Type',
			'group' => 'name',
		);

		$fields_to_return[] = array(
			'key'   => 'facebook_profile_url',
			'label' => 'Facebook Profile URL',
			'group' => 'name',
		);
	}

	return $fields_to_return;
}
add_filter( 'coauthors_guest_author_fields', 'ws_filter_guest_author_fields', 10, 2 );

/**
 * Use Co-Authors for OpenGraph author url, rather than WordPress users
 *
 * @param $profile_url
 *
 * @return mixed
 */
function ws_seo_og_filter_facebook_author( $profile_url ) {
	global $post;

	// Get the Co-Authors for the post
	$co_authors = get_coauthors( $post->ID );

	if ( $co_authors ) {
		$profile_url = $co_authors[0]->facebook_profile_url;
	}
	return $profile_url;
}
add_filter( 'wpseo_opengraph_author_facebook', 'ws_seo_og_filter_facebook_author', 10, 1 );

/**
 * Use filter endpoint template for destinations, interests, and travelers
 *
 * @param $template
 *
 * @return mixed
 */
function ws_filter_endpoints( $template ) {
	$filter_types = array( 'destination', 'interest', 'traveler' );
	$post_type    = get_post_type();

	if ( ! in_array( $post_type, $filter_types ) ) {
		return $template;
	}

	return get_stylesheet_directory() . '/single-filter-endpoint.php';
}
add_filter( 'template_include', 'ws_filter_endpoints' );


/**
 * Include metabox on front page
 *
 * @author Ed Townend
 * @link   https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool  $display
 * @param array $meta_box
 *
 * @return bool display metabox
 */
function ws_metabox_include_front_page( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) ) {
		return $display;
	}

	if ( 'front-page' !== $meta_box['show_on']['key'] ) {
		return $display;
	}

	$post_id = 0;

	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! $post_id ) {
		return $display;
	}

	// Get ID of page set as front page, 0 if there isn't one
	$front_page = get_option( 'page_on_front' );

	// there is a front page set and we're on it!
	return $post_id == $front_page;
}
add_filter( 'cmb2_show_on', 'ws_metabox_include_front_page', 10, 2 );

/**
 * Remove widgets from the dashboard
 */
function remove_dashboard_widgets() {
	remove_meta_box( 'arve_dashboard_widget', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * Send submitted form data to Marketo using munchkin API
 */
 function data_to_marketo() {
	 WS_Marketo::submit_marketo_data();
	 wp_die();
 }
add_action( 'wp_ajax_data_to_marketo', 'data_to_marketo' );
add_action( 'wp_ajax_nopriv_data_to_marketo', 'data_to_marketo' );

/**
 * Add schema.org markup for Site Name to header
 */
function ws_head_add_schema() {
?>
	<script type="application/ld+json">
		{
		  "@context" : "http://schema.org",
		  "@type" : "WebSite",
		  "name" : "WorldStrides",
		  "alternateName" : "<?php echo get_bloginfo( 'name' ); ?>",
		  "url" : "<?php echo esc_url( home_url( '/' ) ); ?>"
		}
	</script>
<?php
}
add_action( 'wp_head', 'ws_head_add_schema' );

function ws_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	ob_start(); ?>
	<div class="ws-container password-protected-page">
		<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
	        To view this protected post, enter the password below:
	        <label for="<?php echo $label; ?>">Password: </label>
			<input name="post_password" id="<?php echo $label; ?>" type="password" size="20" maxlength="20" />
			<input type="submit" name="Submit" value="Submit" />
	    </form>
	</div>
	<?php
	$html = ob_get_contents();
	ob_get_clean();

	return $html;
}

add_filter( 'the_password_form', 'ws_password_form' );

/**
 * Tweak default meta boxes
 *
 * Remove slug metabox from Blocks
 */
function ws_default_meta_boxes() {
	remove_meta_box( 'slugdiv', 'block', 'normal' );
}
add_action( 'add_meta_boxes', 'ws_default_meta_boxes' );

/**
 * Alert users to the existence of the new website
 */
function ws_add_modal_welcome() {
	require_once( WS_PATH . 'partials/modal-welcome.php');
}
//if ( strtotime('28 February 2016') > strtotime('now') ) {
//	add_action( 'wp_footer', 'ws_add_modal_welcome', 10 );
//}

/**
 * Extend the number of redirects we can create dynamically via Safe Redirect Mgr plugin
 */
add_filter( 'srm_max_redirects', 'dbx_srm_max_redirects' );
function dbx_srm_max_redirects() {
    return 300;
}

/**
 * Search the "Internal Trip ID" aka itinerary_details_trip_id
 * For example, PUV for the Pura Vida trip
 * https://codex.wordpress.org/Custom_Queries#Keyword_Search_in_Plugin_Table
 * http://code.tutsplus.com/tutorials/create-a-simple-crm-in-wordpress-extending-wordpress-search-to-include-custom-fields--cms-22953
 * @todo: make this functional
 */
// add_filter('posts_join', 'meta_threecode_search_join' );
// add_filter('posts_where', 'meta_threecode_search_where' );
// add_filter('posts_groupby', 'meta_threecode_search_groupby' );
function meta_threecode_search_join( $join ) {
    global $wp_query, $wpdb;

    if (!empty($wp_query->query_vars['s'])) {
    	$search_string = $wp_query->query_vars['s'];
        $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
        $join .= "AND $wpdb->postmeta.meta_key = 'itinerary_details_trip_id' ";
        $join .= "AND $wpdb->postmeta.meta_value LIKE '%%$search_string%%' ";
    }

    return $join;
}
function meta_threecode_search_where( $where ) {

}
function meta_threecode_search_groupby( $groupby ) {

}

//Threecode Exists
function threecode_exists(){
    global $wpdb,$wp_query;
    if (!empty($wp_query->query_vars['s'])) {
        $search_string = $wp_query->query_vars['s'];

        $results = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.ID = b.post_id  WHERE b.meta_key  = 'itinerary_details_trip_id' AND b.meta_value = '$search_string'" );
        if ($results == 0){
            $exists = false;
        }
        else{
            $exists = true;
        }

        return $exists;
    }
}


//Threecode Search
function threecode_search(){
    global $wpdb,$wp_query;
    if (!empty($wp_query->query_vars['s'])) {
        $search_string = $wp_query->query_vars['s'];

        $qry = "SELECT * FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.ID = b.post_id  WHERE b.meta_key  = 'itinerary_details_trip_id' AND b.meta_value = '$search_string'";
        $results = $wpdb->get_results( $qry );

        wp_reset_query();

        return $results;
    }
}


//Temp Format
function temp_format(){
    global $wpdb;
    $results = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_name = 'temperature_format'" );
    $tempformat = $results;
    return $tempformat;
}

function temp_to_celsius( $degrees ){
    $degrees = (($degrees - 32) * 5/9 );
    return $degrees;
}


//*** WorldStrides Custom Search ***//
function ws_custom_exists(){
    global $wpdb,$wp_query;
    if (!empty($wp_query->query_vars['s'])) {

        $results = ws_custom_count();

        if ($results == 0){
            $exists = false;
        }
        else{
            $exists = true;
        }

        return $exists;
    }
}

function ws_custom_search_query($qry_type){
    global $wpdb,$wp_query;
    $search_string = $wp_query->query_vars['s'];
    $post_type = $wp_query->query_vars['post_type'];       

    $offset = (get_current_page() - 1) * get_max_posts();
    $fetch = get_max_posts();

    //remove basic words array
    $stop_words = array("a", "an", "and", "are", "as", "at", "be", "by", "for", "from", "has", "he", "in", "is", "it", "its", "of", "on", "that", "the", "to", "was", "were", "where", "will", "with");

    //declare variables for sql
    $dyn_sql_three_code = "";
    $dyn_sql_post_title = "";
    $dyn_sql_post_content = "";
    $dyn_sql_post_excerpt = "";
    $dyn_sql_post_meta_value = "";
    $dyn_sql_term_name = "";

    //explode search string into separate search elements
    $search_elements = explode(" ", $search_string);   

    //loop through each search element 
    foreach ($search_elements as $search_element)
    {
        if (!in_array($search_element,$stop_words))
        {
            $dyn_sql_three_code = $dyn_sql_three_code . " OR b.meta_value = '$search_element'";
            $dyn_sql_post_title = $dyn_sql_post_title . " OR p.post_title like '%$search_element%'";
            $dyn_sql_post_content = $dyn_sql_post_content . " OR p.post_content like '%$search_element%'";
            $dyn_sql_post_excerpt = $dyn_sql_post_excerpt . " OR p.post_excerpt like '%$search_element%'";
            $dyn_sql_post_meta_value = $dyn_sql_post_meta_value . " OR b.meta_value like '%$search_element%'";
            $dyn_sql_term_name = $dyn_sql_term_name . " OR term.name like '%$search_element%'";
        }
    }

        

        //select query
        $qry_select = "SELECT *,
                CASE 
                    WHEN p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_details_trip_id' AND (b.meta_value = '$search_string' $dyn_sql_three_code)) THEN 1
                    WHEN p.post_type = 'itinerary' THEN 2
                    WHEN p.post_type = 'resource' THEN 3
                    WHEN p.post_type = 'post' THEN 4
                    ELSE 5
                END AS TypeSort,
                CASE 
					WHEN p.post_type = 'itinerary' THEN (SELECT IFNULL(b.meta_value,5000) FROM $wpdb->postmeta b WHERE b.meta_key = 'post_priority' AND b.post_id = p.ID LIMIT 1) 
                    ELSE (SELECT IFNULL(b.meta_value,100) FROM $wpdb->postmeta b WHERE b.meta_key = '_yoast_wpseo_linkdex' AND b.post_id = p.ID  LIMIT 1)
				END as PostIndex,
                 (SELECT IFNULL(b.meta_value,5000) FROM $wpdb->postmeta b WHERE b.meta_key = 'post_priority' AND b.post_id = p.ID  LIMIT 1)  as PostIndex2
                FROM $wpdb->posts p 
                WHERE p.post_status='publish' 
                AND CASE WHEN ('$post_type' = 'any' OR '$post_type' = 'all') THEN 1=1 ELSE p.post_type = '$post_type' END
                AND (
                    (p.post_title like '%$search_string%' $dyn_sql_post_title)
                    OR (p.post_content like '%$search_string%' $dyn_sql_post_content)
                    OR (p.post_excerpt like '%$search_string%' $dyn_sql_post_excerpt)
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_subtitle' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_highlights_list' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_details_duration' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_details_trip_id' AND (b.meta_value = '$search_string' $dyn_sql_three_code))
                    OR p.Id IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.Id = rel.object_id
                                        JOIN wp_term_taxonomy tax
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
                                        JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
                                            AND (term.name like '%$search_string%' $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
                                        JOIN wp_term_taxonomy tax3
        	                                ON term2.term_id = tax3.term_id
                                        JOIN wp_terms term3
        	                                ON tax3.parent = term3.term_id
                                            AND term3.name = 'Destination')
                    OR p.Id IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.Id = rel.object_id
                                        JOIN wp_term_taxonomy tax
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
                                        JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
                                            AND (term.name like '%$search_string%' $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax3
        	                                ON term2.term_id = tax3.term_id
                                        JOIN wp_terms term3
        	                                ON tax3.parent = term3.term_id
                                            AND term3.name = 'Destination')
                    OR p.ID IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.ID = rel.object_id
		                                JOIN wp_term_taxonomy tax 
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
		                                JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
			                                AND term.name = 'Business'
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
			                                AND (term2.name like '%$search_string%' $dyn_sql_term_name))
                    OR p.ID IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.ID = rel.object_id
		                                JOIN wp_term_taxonomy tax 
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
		                                JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
			                                AND (term.name like '%$search_string%'  $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
			                                AND term2.name = 'traveler')
                )
                ORDER BY TypeSort ASC, PostIndex2 ASC
                LIMIT $offset,$fetch";

                //count query
                $qry_count = "SELECT COUNT(*)
                FROM $wpdb->posts p 
                WHERE p.post_status='publish' 
                AND CASE WHEN ('$post_type' = 'any' OR '$post_type' = 'all') THEN 1=1 ELSE p.post_type = '$post_type' END
                AND (
                    (p.post_title like '%$search_string%' $dyn_sql_post_title)
                    OR (p.post_content like '%$search_string%' $dyn_sql_post_content)
                    OR (p.post_excerpt like '%$search_string%' $dyn_sql_post_excerpt)
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_subtitle' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_highlights_list' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_details_duration' AND (b.meta_value like '%$search_string%' $dyn_sql_post_meta_value))
                    OR p.Id IN (SELECT a.ID FROM $wpdb->posts a JOIN $wpdb->postmeta b ON a.Id = b.post_id WHERE b.meta_key = 'itinerary_details_trip_id' AND (b.meta_value = '$search_string' $dyn_sql_three_code))
                    OR p.Id IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.Id = rel.object_id
                                        JOIN wp_term_taxonomy tax
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
                                        JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
                                            AND (term.name like '%$search_string%' $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
                                        JOIN wp_term_taxonomy tax3
        	                                ON term2.term_id = tax3.term_id
                                        JOIN wp_terms term3
        	                                ON tax3.parent = term3.term_id
                                            AND term3.name = 'Destination')
                    OR p.Id IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.Id = rel.object_id
                                        JOIN wp_term_taxonomy tax
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
                                        JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
                                            AND (term.name like '%$search_string%' $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax3
        	                                ON term2.term_id = tax3.term_id
                                        JOIN wp_terms term3
        	                                ON tax3.parent = term3.term_id
                                            AND term3.name = 'Destination')
                    OR p.ID IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.ID = rel.object_id
		                                JOIN wp_term_taxonomy tax 
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
		                                JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
			                                AND term.name = 'Business'
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
			                                AND (term2.name like '%$search_string%' $dyn_sql_term_name))
                    OR p.ID IN (SELECT p.ID
                                FROM $wpdb->posts p
		                                JOIN wp_term_relationships rel
        	                                ON p.ID = rel.object_id
		                                JOIN wp_term_taxonomy tax 
        	                                ON rel.term_taxonomy_id = tax.term_taxonomy_id
		                                JOIN wp_terms term
        	                                ON tax.term_id = term.term_id
			                                AND (term.name like '%$search_string%'  $dyn_sql_term_name)
                                        JOIN wp_term_taxonomy tax2
        	                                ON term.term_id = tax2.term_id
                                        JOIN wp_terms term2
        	                                ON tax2.parent = term2.term_id
			                                AND term2.name = 'traveler')
                )";

                //message_box($qry_type);

                //evaluate query type and create query
                if ($qry_type == "search")
                {
                    $qry = $qry_select;
                }
                else if ($qry_type == "count")
                {
                    $qry = $qry_count;
                }

                //print $qry;
                return $qry;
}

function ws_custom_search(){
    global $wpdb,$wp_query;
    if (!empty($wp_query->query_vars['s'])) {
     
        $qry = ws_custom_search_query("search");
        $row = $wpdb->get_results( $qry );
        wp_reset_query();

        return $row;
    }
}


function ws_custom_count(){
    global $wpdb,$wp_query, $wp_custom_search_count;
    if (!empty($wp_query->query_vars['s'])) {

        $qry = ws_custom_search_query("count");
        $results = $wpdb->get_var( $qry );
        //$results = wp_count_posts(ws_custom_search()); //can be used without paging

        $wp_custom_search_count = $results;
        //message_box($wp_custom_search_count);

        return $results;
    }
}



//Get Country TODO
function ws_get_country($postid){
    global $wpdb;
    if (!empty($postid)) {

        $qry = "SELECT p.* FROM $wpdb->posts p JOIN $wpdb->postmeta pm ON p.ID = pm.post_id  WHERE p.id = $postid";
        $results = $wpdb->get_results( $qry );

        wp_reset_query();

        return $results;
    }
}



// Pagination
function get_current_page(){
    global $wp_query;
    $currentpage = $wp_query->query_vars['paged'];
    if ($currentpage == '') { 
        $currentpage = 1;
    }
    return $currentpage;
}

function get_max_pages(){
    global $wp_query, $wp_custom_search_count;
    $maxpages = 10; //max pages override $wp_query->max_num_pages
    $postcount = $wp_custom_search_count; //ws_custom_count()
    $postmaxpages = CEIL($postcount/$maxpages);
    
    message_box("PostCount: $postcount , MaxPages: $maxpages , PostMaxPages: $postmaxpages");

    if ($postmaxpages > $maxpages) {
        $postmaxpages = $maxpages;
    } 

    message_box("PostCount: $postcount , MaxPages: $maxpages , PostMaxPages: $postmaxpages");

    return $postmaxpages;
}

function get_max_posts(){
    $postmaxcount = get_option('posts_per_page');
    return $postmaxcount;
}

function get_pagination(){
global $wp_query;

    $pagearray = array(
	    'base'               => '%_%',
	    'format'             => '?paged=%#%',
	    'total'              => get_max_pages(),
	    'current'            => get_current_page(),
	    'show_all'           => false,
	    'end_size'           => 1,
	    'mid_size'           => 2,
	    'prev_next'          => true,
	    'prev_text'          => __('<< Previous'),
	    'next_text'          => __('Next >>'),
	    'type'               => 'plain',
	    'add_args'           => false,
	    'add_fragment'       => '',
	    'before_page_number' => '',
	    'after_page_number'  => ''
        ); 

    return $pagearray;
}


//Get Review Data

function get_pr_page_id($postid){

    $powerreviews_pairs = array(
        array( 'uri' =>	"/collections/smithsonian-university-travel-programs/",		'pr_page_id' =>	'smithsonian-university-travel-programs' ),
        array( 'uri' =>	"/collections/reliving-us-history/",						    'pr_page_id' =>	'history-themed-programs' ),
        array( 'uri' =>	"/collections/science-discoveries/",						    'pr_page_id' =>	'science-themed-programs' ),
        array( 'uri' =>	"/collections/american-performing-tours/",				    	'pr_page_id' =>	'american-performing-tours' ),
        array( 'uri' =>	"/collections/dance-and-cheer-programs/",					    'pr_page_id' =>	'bowl-games-parades-dance' ),
        array( 'uri' =>	"/collections/marching-band-programs/",						'pr_page_id' =>	'bowl-games-parades-marching-band' ),
        array( 'uri' =>	"/collections/career-focused-programs/",					    'pr_page_id' =>	'career-focused-programs' ),
        array( 'uri' =>	"/collections/faith-based-concert-tours/",					    'pr_page_id' =>	'faith-based-concert-tours' ),
        array( 'uri' =>	"/collections/festival-at-carnegie-hall/",				    	'pr_page_id' =>	'festival-carnegie-hall-elite-performing' ),
        array( 'uri' =>	"/collections/festival-of-gold/",							    'pr_page_id' =>	'festival-gold-elite-performing' ),
        array( 'uri' =>	"/collections/heritage-festivals/",							'pr_page_id' =>	'heritage-festivals' ),
        array( 'uri' =>	"/collections/international-concert-tours/",			    	'pr_page_id' =>	'international-concert-tours' ),
        array( 'uri' =>	"/collections/perspectives-on-central-and-eastern-europe/",	'pr_page_id' =>	'central-and-eastern-europe' ),
        array( 'uri' =>	"/collections/italian-and-greek-influence/",			    	'pr_page_id' =>	'italy-and-greece' ),
        array( 'uri' =>	"/collections/a-european-perspective/",						'pr_page_id' =>	'multiple-european-countries' ),
        array( 'uri' =>	"/collections/french-and-spanish-influence/",			    	'pr_page_id' =>	'spain-and-france' ),
        array( 'uri' =>	"/collections/focus-on-the-americas/",					    	'pr_page_id' =>	'americas' ),
        array( 'uri' =>	"/collections/a-uk-perspective/",						    	'pr_page_id' =>	'britain-and-ireland' ),
        array( 'uri' =>	"/collections/discover-colonial-history/",				    	'pr_page_id' =>	'discover-colonial-history' ),
        array( 'uri' =>	"/collections/florida-science-discovery/",				    	'pr_page_id' =>	'florida-science-discovery' ),
        array( 'uri' =>	"/collections/costa-rica-science-discovery/",			    	'pr_page_id' =>	'costa-rica-science-discovery' ),
        array( 'uri' =>	"/collections/california-history-discovery/",			    	'pr_page_id' =>	'california-history-discovery' ),
        array( 'uri' =>	"/collections/new-york-history-discovery/",					'pr_page_id' =>	'new-york-history-discovery' ),
        array( 'uri' =>	"/collections/illinois-history-discovery/",					'pr_page_id' =>	'illinois-history-discovery' ),
        array( 'uri' =>	"/collections/a-focus-on-christian-travel/",		    		'pr_page_id' =>	'a-focus-on-christian-travel' ),
        array( 'uri' =>	"/collections/discover-washington-d-c/",			    		'pr_page_id' =>	'washington-dc-programs' )
        );

        $powerreviews_pairs_local = array(
        array( 'uri' =>	"/worldstrides/collections/smithsonian-university-travel-programs/",		'pr_page_id' =>	'smithsonian-university-travel-programs' ),
        array( 'uri' =>	"/worldstrides/collections/reliving-us-history/",						    'pr_page_id' =>	'history-themed-programs' ),
        array( 'uri' =>	"/worldstrides/collections/science-discoveries/",						    'pr_page_id' =>	'science-themed-programs' ),
        array( 'uri' =>	"/worldstrides/collections/american-performing-tours/",				    	'pr_page_id' =>	'american-performing-tours' ),
        array( 'uri' =>	"/worldstrides/collections/dance-and-cheer-programs/",					    'pr_page_id' =>	'bowl-games-parades-dance' ),
        array( 'uri' =>	"/worldstrides/collections/marching-band-programs/",						'pr_page_id' =>	'bowl-games-parades-marching-band' ),
        array( 'uri' =>	"/worldstrides/collections/career-focused-programs/",					    'pr_page_id' =>	'career-focused-programs' ),
        array( 'uri' =>	"/worldstrides/collections/faith-based-concert-tours/",					    'pr_page_id' =>	'faith-based-concert-tours' ),
        array( 'uri' =>	"/worldstrides/collections/festival-at-carnegie-hall/",				    	'pr_page_id' =>	'festival-carnegie-hall-elite-performing' ),
        array( 'uri' =>	"/worldstrides/collections/festival-of-gold/",							    'pr_page_id' =>	'festival-gold-elite-performing' ),
        array( 'uri' =>	"/worldstrides/collections/heritage-festivals/",							'pr_page_id' =>	'heritage-festivals' ),
        array( 'uri' =>	"/worldstrides/collections/international-concert-tours/",			    	'pr_page_id' =>	'international-concert-tours' ),
        array( 'uri' =>	"/worldstrides/collections/perspectives-on-central-and-eastern-europe/",	'pr_page_id' =>	'central-and-eastern-europe' ),
        array( 'uri' =>	"/worldstrides/collections/italian-and-greek-influence/",			    	'pr_page_id' =>	'italy-and-greece' ),
        array( 'uri' =>	"/worldstrides/collections/a-european-perspective/",						'pr_page_id' =>	'multiple-european-countries' ),
        array( 'uri' =>	"/worldstrides/collections/french-and-spanish-influence/",			    	'pr_page_id' =>	'spain-and-france' ),
        array( 'uri' =>	"/worldstrides/collections/focus-on-the-americas/",					    	'pr_page_id' =>	'americas' ),
        array( 'uri' =>	"/worldstrides/collections/a-uk-perspective/",						    	'pr_page_id' =>	'britain-and-ireland' ),
        array( 'uri' =>	"/worldstrides/collections/discover-colonial-history/",				    	'pr_page_id' =>	'discover-colonial-history' ),
        array( 'uri' =>	"/worldstrides/collections/florida-science-discovery/",				    	'pr_page_id' =>	'florida-science-discovery' ),
        array( 'uri' =>	"/worldstrides/collections/costa-rica-science-discovery/",			    	'pr_page_id' =>	'costa-rica-science-discovery' ),
        array( 'uri' =>	"/worldstrides/collections/california-history-discovery/",			    	'pr_page_id' =>	'california-history-discovery' ),
        array( 'uri' =>	"/worldstrides/collections/new-york-history-discovery/",					'pr_page_id' =>	'new-york-history-discovery' ),
        array( 'uri' =>	"/worldstrides/collections/illinois-history-discovery/",					'pr_page_id' =>	'illinois-history-discovery' ),
        array( 'uri' =>	"/worldstrides/collections/a-focus-on-christian-travel/",		    		'pr_page_id' =>	'a-focus-on-christian-travel' ),
        array( 'uri' =>	"/worldstrides/collections/discover-washington-d-c/",			    		'pr_page_id' =>	'washington-dc-programs' )
        );

        $post_url = parse_url(get_permalink($postid), PHP_URL_PATH);
        $pr_page_id  = '';

        //get collection for itinerary        
        $collectionid = get_itinerary_collection($postid);
        $post_url = parse_url(get_permalink($collectionid), PHP_URL_PATH);
        //print 'POSTID: ' . $postid . '<br><p>';
        //print 'URL: ' . $post_url . '<br><p>';

        foreach ( $powerreviews_pairs as $powerreviews_pair ) {
	        if( $post_url === $powerreviews_pair['uri'] ) {
		        $pr_page_id = $powerreviews_pair['pr_page_id'];
                //print 'MATCH: ' . $pr_page_id . '<br>';
            } else {
                //print 'NOMATCH: ' . $powerreviews_pair['uri'] . '<br>';
            }
        }

        //$pr_page_id = 'washington-dc-programs';
        return $pr_page_id;
}


function get_itinerary_collection($postid){
    global $wpdb,$wp_query;    
   
    $collectionid = $wpdb->get_var( "SELECT p2.ID
                                    FROM $wpdb->posts p
		                                    join wp_term_relationships tr
        	                                    on p.ID = tr.object_id
                                            join wp_term_taxonomy tx
        	                                    on tr.term_taxonomy_id = tx.term_taxonomy_id
                                                and tx.taxonomy = '_collection'
                                            join wp_terms tm
        	                                    on tx.term_id = tm.term_id
                                            join $wpdb->posts p2
        	                                    on tm.name = p2.post_title
                                                and p2.post_type = 'collection'
                                    WHERE p.ID = $postid
                                    LIMIT 1");

    //$collectionid = 844;
    return $collectionid;
}

function message_box($message){
    echo '<script>alert("' . $message . '");</script>';
}