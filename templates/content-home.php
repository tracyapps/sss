<div class="row home-intro lighter">
	<div class="col-xs-6 intro-text">
		<?php $site_global_content = get_option( 'option_fields' );

		if ( $site_global_content[ 'tagline' ] != '' ) {
			echo '<h1>' . esc_html( $site_global_content[ 'tagline' ] ) . '</h1>';
		} else {
			echo '<h1>' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
		}
		if ( $site_global_content[ 'additional-intro' ] != '' ) {
			echo '<p>' . esc_html( $site_global_content[ 'additional-intro' ] ) . '</p>';
		}
		?>
	</div>
	<div class="col-xs-6 intro-slides">

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
			$the_icon_path = get_template_directory() . '/assets/img/icons/png/';
			$the_icon_array = array_diff( scandir( $the_icon_path ), array( '..', '.' ) );
			$the_icon_array = array_map( function( $e ) {
				return pathinfo( $e, PATHINFO_FILENAME );
			}, $the_icon_array );

			foreach ( $service_boxes as $service_box ) :
				$icon_id = esc_html( $service_box[ 'service_icon' ] );

				echo '<div class="service"><div class="icon-' . $the_icon_array[$icon_id] . ' icon" style="width: 140px; height: 140px; margin: 10px auto;"></div><h5>' . esc_html( $service_box[ 'service_title' ] ) . '</h5><p>' . wp_kses_post( $service_box[ 'service_description' ] ) . '</p></div>';
			endforeach;  ?>
		</section>
	</div>
</div>
<div class="row white content-container">
	<div class="col-xs-12">

	</div>
</div>