<?php
if(get_the_tag_list()) {
	echo '<div class="blog-tags">';
	echo '<span>Tagged in</span><br>';
    echo get_the_tag_list('<ul class="list-unstyled blog-tags-list"><li>','</li><li>','</li></ul>');
    echo '</div>';
}
?>