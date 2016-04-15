<?php
/**
 * Template Name: User profile
 */
?>

<?php get_header(); ?>

<div id="content">
    <?php if ( is_active_sidebar( 'top' ) ) : ?>
        <?php if ( dynamic_sidebar( 'top' ) ) : ?><?php endif; ?>
    <?php endif ?>

    <div class="container">
        <div class="row">
            <div id="main" class="col-md-12">
              <?php if ( !is_user_logged_in() ) : ?>
                <?php aviators_add_message(__('You need to be logged in to access your login page', 'aviators'), 'warning'); ?>
              <?php endif; ?>
              <?php echo aviators_render_messages(); ?>
                <?php if ( dynamic_sidebar( 'content-top' ) ) : ?><?php endif; ?>

                <div class="row">
                    <?php if ( is_user_logged_in() ) : ?>

                      <div class="col-md-4 col-md-offset-4">
                          <?php while ( have_posts() ) : the_post(); ?>
                              <?php get_template_part( 'content', get_post_format() ); ?>
                          <?php endwhile; ?>

                          <?php
                          $id = wp_get_current_user();
                          if(isset($_GET['id'])) {
                            $id = $_GET['id'];
                          }
                          ?>
                          <?php $profile_id = _aviators_profile_get_user_profile_id($id) ;?>
                          <?php echo hydra_render_frontend_submission( $profile_id, 'profile' ); ?>
                      </div><!-- /.col-md-4 -->
                    <?php endif; ?>
                </div><!-- /.row -->

                <?php if ( dynamic_sidebar( 'content-bottom' ) ) : ?><?php endif; ?>
            </div><!-- /#main -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    <?php if ( get_sidebar( 'bottom' ) ) : ?><?php endif ?>
</div><!-- /#content -->

<?php get_footer(); ?>