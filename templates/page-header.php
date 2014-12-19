<header class="page-header">
	<?php if ( has_post_thumbnail() ) {
		echo '<div class="featured-image">';
		the_post_thumbnail('page-featured-image');
		echo '</div>';
	} ?>
	<h1>
		<?php echo roots_title(); ?>
	</h1>
</header>
