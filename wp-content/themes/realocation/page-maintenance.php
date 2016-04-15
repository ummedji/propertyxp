<?php
/**
 * Template Name: Maintenance
 */
?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Aviators, http://aviators.com">

    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png" type="image/png">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
    
    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>

    <title><?php echo wp_title( '|', FALSE, 'right' ); ?></title>
</head>

<body <?php body_class(); ?>>
	<div class="maintenance-wrapper">
		<div class="maintenance">
			<div class="maintenance-inner">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<?php if ( have_posts() ) : ?>
								<?php while( have_posts() ): the_post(); ?>
									<?php get_template_part('content'); ?>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div><!-- /.maintenance-inner -->
		</div><!-- /.maintentenance -->
	</div><!-- /.maintenance-wrapper -->
	<?php wp_footer(); ?>
	<?php aviators_footer(); ?>
</body>
</html>