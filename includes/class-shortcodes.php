<?php
/**
 * Add shortcodes
 *
 * Class WS_Shortcodes
 */
class WS_Shortcodes {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Shortcodes
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Shortcodes
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new static();
			self::$_instance->_init();
		}

		return self::$_instance;
	}

	public function __construct() {
		// I don't do anything
	}

	/**
	 * Sets up actions and filters.
	 */
	protected function _init() {
		add_shortcode( 'timeline', array( $this, 'timeline' ) );
		add_shortcode( 'timeline-node', array( $this, 'timeline_node' ) );
		add_shortcode( 'button', array( $this, 'button' ) );
		add_shortcode( 'activity', array( $this, 'activity' ) );
		add_shortcode( 'formstack', array( $this, 'formstack' ) );
		add_shortcode( 'columns', array( $this, 'columns' ) );
		add_shortcode( 'column', array( $this, 'column' ) );
		add_shortcode( 'powerreviews', array( $this, 'powerreviews' ) );
	}

	/**
	 * Create a timeline shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return html content wrapped in a unordered list
	 */
	public static function timeline( $atts, $content = "" ) {
		$content = '<ul class="timeline">' . do_shortcode( $content ) . '</ul>';
		$content = str_replace( '\r\n', "\n", $content );
		return $content;
	}

	/**
	 * Creates a year shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return html content wrapped in a unordered list
	 */
	public static function timeline_node( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'year' => '',
		), $atts, 'timeline-node' );

		ob_start();
		?>
			<li class="timeline-event">
				<span class="timeline-year h6"><?php echo $atts['year'];?></span>
				<p class="timeline-content"><?php echo $content; ?>
			</li>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates a button shortcode.
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string link with button classes 
	 */
	public static function button( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'url' => '',
			'id' => '',
			'data_form_comment' => '',
			'color' => 'orange',
			'new_window' => false
		), $atts, 'timeline-node' );

		if ( 'blue' == $atts['color'] ) {
			$class = 'btn-info';
		} else if ( 'purple' == $atts['color'] ) {
			$class = 'btn-majestic';
		} else {
			$class = 'btn-primary';
		}

		if ( $atts['new_window'] ) {
			$target = 'target="_blank"';
		} else {
			$target = '';
		}

		ob_start();
		?>
		<a href="<?php echo $atts['url'];?>" 
		   id="<?php echo $atts['id'];?>"
		   class="btn <?php echo esc_attr( $class ); ?>"
		   data-form-comment="<?php echo $atts['data_form_comment']; ?>"
		   <?php echo $target; ?>><?php echo esc_html( $content ); ?></a>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates an activity shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string content wrapped in a unordered list
	 */
	public static function activity( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'title' => '',
		), $atts, 'activity' );

		ob_start();
		?>
		<li>
			<strong><?php echo $atts['title'];?></strong>
			<span><?php echo $content; ?></span>
		</li>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates a Formstack shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string content wrapped in a unordered list
	 */
	public static function formstack( $atts ) {
		$atts = shortcode_atts( array(
			'slug' => '',
			'title' => '',
		), $atts, 'formstack' );

		ob_start();
		?>
		<script type="text/javascript" src="https://wsforms.formstack.com/forms/js.php/<?php echo $atts['slug'];?>"></script>
		<noscript><a href="https://wsforms.formstack.com/forms/<?php echo $atts['slug'];?>" title="<?php echo $atts['title'];?>"><?php echo $atts['title'];?></a></noscript>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates a columns shortcode
	 *
	 * @return html wrapper for columns
	 */
	public static function columns( $atts, $content = "" ) {
		$content = '<div class="columns clearfix">' . do_shortcode( $content ) . '</div>';
		$content = str_replace( '\r\n', "\n", $content );
		return $content;
	}

	/**
	 * Creates a column shortcode
	 *
	 * @return html content for a column
	 */
	public static function column( $atts, $content = "" ) {
		ob_start(); ?>
			
			<div class="column"><?php echo $content; ?></div>

		<?php
		$html = ob_get_contents();
        $html = do_shortcode( $html );
		ob_get_clean();

		return $html;
	}


	/**
	 * Creates a powerreviews shortcode
	 *
	 * @return html content for a powerreviews
	 *
	 * @todo REFACTOR - JS include should be elsewhere!
	 */
	public static function powerreviews( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'pr_page_id' => ''
		), $atts, 'powerreviews' );

		if('' === $atts['pr_page_id'] ) {
			return '';
		}

		ob_start(); ?>
			
			<div class="powerreviews">
				<?php echo $content; ?>
				<script type="text/javascript" src="https://wsreviews:reviewsINprogress@reviews.worldstrides.com/pwr/engine/js/full.js">
				</script>
				<script type="text/javascript">
					'use strict';
					var pr_locale="en_US";
					var pr_page_id= <?php echo '"' . $atts['pr_page_id'] . '"'; ?> ;
					var pr_write_review='https://reviews.worldstrides.com/write_a_review.html?pr_page_id=' + pr_page_id;
					var pr_zip_location="https://wsreviews:reviewsINprogress@reviews.worldstrides.com/";
					// var pr_ask_question = pr_write_review + pr_page_id + "&appName=askQuestion";
					// var pr_answer_question = pr_write_review + pr_page_id + "&appName=answerQuestion&questionId=@@@QUESTION_ID@@@";
				</script>
				<div class="pr_snippet_product">
					<script type="text/javascript">
						'use strict';
						POWERREVIEWS.display.snippet(document);
					</script>
				</div>
				<div id="pr_loading_wait" class="hidden">Please Wait for Reviews to Load...</div>
				<div id="pr_review_summary" class="pr_review_summary hidden"> 
					<script type="text/javascript">
						'use strict';
						POWERREVIEWS.display.engine(document);

						// document.getElementById("pr_review_summary").addEventListener("click", function() {
						// document.getElementById("pr-snippet-read-link-washington__dc__programs").addEventListener("click", function() {
						//	document.getElementById("pr_review_summary").className = "pr_review_summary";
						// });

						document.querySelector('body').addEventListener('click', function(event) {
						  if (event.target.className === 'pr-snippet-link') {
						  	if( document.getElementById("pr-review-sort") ) {
							    document.getElementById("pr_review_summary").className = "pr_review_summary"; // remove hidden class
						  	} else{
							    document.getElementById("pr_loading_wait").className = ""; // remove hidden class
						  	}
						  }
						});
					</script> 
				</div>
			</div>

		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

}

WS_Shortcodes::instance();
