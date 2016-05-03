/**
 * Created by LoganK on 4/21/2016.
 */
( function( $, window, undefined ) {

    'use strict';

    //Remove <br> tags from in between images and captions
    $(document).ready(function(){
       jQuery('figure > br').remove(); 
    });
    

})(jQuery, window);