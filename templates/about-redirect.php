<?php
/**
 * Template Name: About - Redirect
 *
 * Will redirect the main about page to the history subpage
 */

wp_redirect( get_permalink() . 'history/', 302 );
exit;