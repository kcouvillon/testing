<ul class="blog-social-links list-unstyled">
	<li>
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_the_permalink() ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook">
   			<i class="icon-facebook"></i> Share on Facebook
		</a>
	</li>
	<li>
		<a href="https://twitter.com/share?url=<?php echo urlencode( get_the_permalink() ); ?>&via=worldstrides&text=<?php echo urlencode( get_the_title() ); ?>"
		   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
		   target="_blank" title="Share on Twitter">
		   <i class="icon-twitter"></i> Share on Twitter
	   </a>
	</li>
	<li>
		<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_the_permalink() ); ?>&title=<?php echo urlencode( get_the_title() ); ?>"
		   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
		   target="_blank" title="Share on Twitter">
			<i class="icon-linkedin"></i> Share on LinkedIn
		</a>
	</li>
	<li>
		<a href="mailto:?subject=I%20thought%20you%20would%20enjoy%20this%20article&body=<?php echo urlencode( get_the_permalink() ); ?>">
			<i class="icon-email"></i> Email a friend
		</a>
	</li>
</ul>