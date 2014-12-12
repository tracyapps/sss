<div class="row home-intro lighter">
	<div class="col-xs-6">
		<?php $site_global_content = get_option( 'option_fields' );

		echo '<h1>' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
		if ( $site_global_content[ 'tagline' ] != '' ) {
			echo '<h3>' . esc_html( $site_global_content[ 'tagline' ] ) . '</h3>';
		}
		if ( $site_global_content[ 'additional-intro' ] != '' ) {
			echo '<p>' . esc_html( $site_global_content[ 'additional-intro' ] ) . '</p>';
		}
		?>
	</div>
	<div class="col-xs-6">

		<div id="carousel" class="carousel slide" data-ride="carousel">

			<!-- slides -->
			<div class="carousel-inner" role="listbox">
				<?php $homepage_slides = get_post_meta( get_the_ID(), 'homepage_slideshow', true );
				foreach ( $homepage_slides as $homepage_slide ) : ?>

					<div class="item">
						<?php echo wp_get_attachment_image( $homepage_slide[ 'media_field' ], 'homepage-slide' ); ?>
						<?php if ( $homepage_slide[ 'slide_caption' ] != '' ) {
							echo '<div class="carousel-caption">' . esc_html( $homepage_slide[ 'slide_caption' ] ) . '</div>';
						} // end if there is a caption ?>
					</div>

				<?php endforeach; ?>
			</div>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div>
<div class="row white content-container">
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
</div>
<div class="row darker content-container">
	<div class="col-xs-12">
		<h2>Services</h2>
		<section class="services-container">
			<?php $service_boxes = get_post_meta( get_the_ID(), 'homepage_service_box', true );
			//print_r($homepage_services);
			foreach ( $service_boxes as $service_box ) :

				echo '<div class="service">' . esc_html( $service_box[ 'service_icon' ] ) . '<h5>' . esc_html( $service_box[ 'service_title' ] ) . '</h5><p>' . wp_kses_post( $service_box[ 'service_description' ] ) . '</p></div>';
			endforeach;  ?>
		</section>
	</div>
</div>