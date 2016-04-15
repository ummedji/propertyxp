<div class="header-navigation">
    <div class="container">
        <div class="row">
            <nav class="collapse header-nav nav-collapse" role="navigation">
                <?php wp_nav_menu( array(
                    'theme_location' => 'main',
                    'fallback_cb' => false,
                    'menu_class' => 'nav nav-pills',
                    'container_class' => '',
                ) ); ?>
            </nav>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.header-navigation -->