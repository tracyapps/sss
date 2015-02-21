<div class="row home-intro lighter">
	<div class="col-xs-12 col-md-6 intro-text">
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
	<div class="col-xs-12 col-md-6 intro-slides">

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
<div class="row white content-container" id="home">
	<div class="col-xs-12">
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
	</div>
</div>
<div class="row darker content-container" id="services">
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
		<?php $service_read_more = get_post_meta( get_the_ID(), 'services_more_button', true );
		if ( $service_read_more != '' ) {
			echo '<p class="text-center"><a href="' . esc_url( $service_read_more['services_more_link'] ) . '" class="btn btn-primary btn-lg">' . esc_html( $service_read_more['services_more_text'] ) . '&nbsp;&raquo;</a></p>';
		} ?>
	</div>
</div>
<?php if ( $site_global_content[ 'hours' ] != '' ) { ?>
	<div class="row white content-container" id="hours">
		<div class="col-xs-12 jumbotron">
			<h2>Hours</h2>
			<p><?php esc_html_e( $site_global_content[ 'hours' ] ); ?> </p>
			<p class="text-right"><a href="<?php echo esc_url( $site_global_content[ 'contact_us_link' ] ); ?>" class="btn btn-primary btn-lg">Contact us &raquo;</a></p>
		</div>
	</div>

<?php } //end if there are hours entered into the global content area ?>
<?php $locations = get_post_meta( get_the_ID(), 'homepage_locations', true );
if ( $locations != '' ) { ?>
	<div class="row white content-container" id="location">
		<div class="col-xs-12">
			<h2>Where to find us</h2>
			<section class="locations-container">
				<?php foreach ( $locations as $location ) : ?>
					<div class="location">
						<div class="first-column">
							<div class="padding">
								<h6><?php esc_html_e( $location['location_title'] ); ?></h6>
								<address>
									<?php if ( $location['location_address'] != '' ) {
										echo esc_html( $location['location_address'] ) . '<br />';
									} ?>
									<?php if ( $location['location_citystate'] != '' ) {
										echo esc_html( $location['location_citystate'] ) . '<br />';
									} ?>
								</address>
								<?php if ( $location['location_description'] != '' ) {
									echo '<p>' . wp_kses_post( $location['location_description'] ) . '</p>';
								} ?>
							</div>
						</div>
						<div class="second-column">
							<?php if ( $location['location_lat'] && $location['location_lng'] != '' ) {
								echo '<div class="google-map" data-lat="' . esc_html( $location['location_lat'] ) . '" data-lng="' . esc_html( $location['location_lng'] ) . '"></div>';
							} ?>
						</div>
					</div>
				<?php endforeach; ?>
			</section>
		</div>
	</div>
<?php } // end if there are locations entered ?>
<?php $query = new WP_Query( array(
		'post_type'		=> 'testimonial',
		'orderby'		=> 'rand',
		'posts_per_page' => 2,
	)
);
if ( $query->have_posts() ) :
	echo '<div class="row darker content-container" id="testimonials"><h2>What our clients say</h2><section class="testimonials-container">';
	while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="testimonial">
			<?php the_content(); ?>
		</div>
<?php endwhile;
	echo '</section></div>';
endif;  // end if there are testimonials ?>