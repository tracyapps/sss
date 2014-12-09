<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 8]>
	<div class="alert alert-warning">
		<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
	</div>
	<![endif]-->

	<?php
	do_action( 'get_header' );
	get_template_part( 'templates/header' );
	?>
	<div class="parallax-window bg" data-parallax="scroll" data-image-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-01.jpg"></div>
	<div class="wrap container" role="document">
		<header class="banner navbar navbar-inverse navbar-static-top row" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<nav class="collapse navbar-collapse" role="navigation">
					<?php
					if (has_nav_menu('primary_navigation')) :
						wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
					endif;
					?>
				</nav>
			</div>
		</header>
		<div class="content row">
			<main class="main" role="main">
				<?php include roots_template_path(); ?>
			</main><!-- /.main -->
		<?php if ( roots_display_sidebar() ) : ?>
			<aside class="sidebar" role="complementary">
				<?php include roots_sidebar_path(); ?>
			</aside><!-- /.sidebar -->
		<?php endif; ?>
		</div><!-- /.content -->
	</div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>

  <?php wp_footer(); ?>

</body>
</html>
