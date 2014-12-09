<header class="the-page-header branding container" role="banner">
	<div class="col-xs-12 col-md-6">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sss-logo.png" class="logo"></a>
	</div>
	<div class="col-xs-12 col-md-6 text-right">
		<?php dynamic_sidebar( 'sidebar-header' ); ?>
	</div>
</header>
