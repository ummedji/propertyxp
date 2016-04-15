<?php

/**
 * Sidebars
 */
function aviators_sidebars() {
    register_sidebar(array(
        'name' => __('Primary', 'aviators'),
        'id' => 'sidebar-1', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
    ));

    register_sidebar(array(
      'name' => __('Topbar Left', 'aviators'),
      'id' => 'topbar-left', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',)
    );

    register_sidebar(array(
            'name' => __('Top: Full Width', 'aviators'),
            'id' => 'top-fullwidth', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
            'description' => __('Use for "Homepage" and "Empty page" page template. No sidebar.', 'aviators')
        )
    );

    register_sidebar(array(
      'name' => __('Top', 'aviators'),
      'id' => 'top', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>'
    ));

    register_sidebar(array(
      'name' => __('Content Top', 'aviators'),
      'id' => 'content-top', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
      'description' => __('Use for pages with content.', 'aviators')
      )
    );

    register_sidebar(array(
      'name' => __('Content Bottom', 'aviators'),
      'id' => 'content-bottom', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
            'description' => __('Use for pages with content.', 'aviators')
      )
    );

    register_sidebar(array(
        'name' => __('Footer First Column', 'aviators'),
        'id' => 'footer-first-column', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>', )
    );

    register_sidebar(array(
        'name' => __('Footer Second Column', 'aviators'),
        'id' => 'footer-second-column', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>', )
    );

    register_sidebar(array(
            'name' => __('Footer Third Column', 'aviators'),
            'id' => 'footer-third-column', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>', )
    );

    register_sidebar(array(
      'name' => __('Bottom', 'aviators'),
      'id' => 'bottom', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
      'description' => __('Widgets are situated under the main content area and widget.', 'aviators')
      )
    );

    register_sidebar(array(
            'name' => __('Footer Lower Left', 'aviators'),
            'id' => 'footer-lower-left', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
            'description' => __('Widgets are situated under the main content area and widget.', 'aviators')
        )
    );

    register_sidebar(array(
            'name' => __('Footer Lower Right', 'aviators'),
            'id' => 'footer-lower-right', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
            'description' => __('Widgets are situated under the main content area and widget.', 'aviators')
        )
    );


    register_sidebar(array(
      'name' => __('Footer Bottom', 'aviators'),
      'id' => 'footer-bottom', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>', )
    );
    
    register_sidebar(array(
    'name' => __('Map Mode: Full Width', 'aviators'),
    'id' => 'mapmode-fullwidth', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>',
    'description' => __('Use for "Homepage" and "Empty page" page template. No sidebar.', 'aviators')
    )
    );
    
}
add_action('widgets_init', 'aviators_sidebars');