<?php

/**
 * Output a complete commenting form for use within a template.
 *
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comment_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comment_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 3.0.0
 *
 * @param array       $args {
 *     Optional. Default arguments and form fields to override.
 *
 *     @type array 'fields' {
 *         Default comment fields, filterable by default via the 'comment_form_default_fields' hook.
 *
 *         @type string 'author' The comment author field HTML.
 *         @type string 'email'  The comment author email field HTML.
 *         @type string 'url'    The comment author URL field HTML.
 *     }
 *     @type string 'comment_field'        The comment textarea field HTML.
 *     @type string 'must_log_in'          HTML element for a 'must be logged in to comment' message.
 *     @type string 'logged_in_as'         HTML element for a 'logged in as <user>' message.
 *     @type string 'comment_notes_before' HTML element for a message displayed before the comment form.
 *                                         Default 'Your email address will not be published.'.
 *     @type string 'comment_notes_after'  HTML element for a message displayed after the comment form.
 *                                         Default 'You may use these HTML tags and attributes ...'.
 *     @type string 'id_form'              The comment form element id attribute. Default 'commentform'.
 *     @type string 'id_submit'            The comment submit element id attribute. Default 'submit'.
 *     @type string 'title_reply'          The translatable 'reply' button label. Default 'Leave a Reply'.
 *     @type string 'title_reply_to'       The translatable 'reply-to' button label. Default 'Leave a Reply to %s',
 *                                         where %s is the author of the comment being replied to.
 *     @type string 'cancel_reply_link'    The translatable 'cancel reply' button label. Default 'Cancel reply'.
 *     @type string 'label_submit'         The translatable 'submit' button label. Default 'Post a comment'.
 *     @type string 'format'               The comment form format. Default 'xhtml'. Accepts 'xhtml', 'html5'.
 * }
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object to generate the form for. Default current post.
 */
function aviators_comment_form( $args = array(), $post_id = null ) {
    if ( null === $post_id )
        $post_id = get_the_ID();
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = wp_parse_args( $args );
    if ( ! isset( $args['format'] ) )
        $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = 'html5' === $args['format'];
    $fields   =  array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'aviators' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'aviators' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
        'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'aviators' ) . '</label> ' .
            '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
    );

    $required_text = sprintf( ' ' . __('Required fields are marked %s', 'aviators'), '<span class="required">*</span>' );

    /**
     * Filter the default comment form fields.
     *
     * @since 3.0.0
     *
     * @param array $fields The default comment fields.
     */
    $fields = apply_filters( 'comment_form_default_fields', $fields );
    $defaults = array(
        'fields'               => $fields,
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'aviators' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'aviators' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'aviators' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'aviators' ) . ( $req ? $required_text : '' ) . '</p>',
        'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'aviators' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => __( 'Leave a Reply', 'aviators' ),
        'title_reply_to'       => __( 'Leave a Reply to %s', 'aviators' ),
        'cancel_reply_link'    => __( 'Cancel reply', 'aviators' ),
        'label_submit'         => __( 'Post Comment', 'aviators' ),
        'format'               => 'xhtml',
    );

    /**
     * Filter the comment form default arguments.
     *
     * Use 'comment_form_default_fields' to filter the comment fields.
     *
     * @since 3.0.0
     *
     * @param array $defaults The default comment form arguments.
     */
    $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

    ?>
    <?php if ( comments_open( $post_id ) ) : ?>
        <?php
        /**
         * Fires before the comment form.
         *
         * @since 3.0.0
         */
        do_action( 'comment_form_before' );
        ?>
        <div id="respond" class="comment-respond">
            <div class="decorated-title">
                <div class="decorated-title-inner">
                    <div class="rules"></div><!-- /.rules-->
                    <h2 class="title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h2>
                    <div class="rules"></div><!-- /.rules-->
                </div><!-- /.decorated-title-inner -->
            </div>


            <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
                <?php echo $args['must_log_in']; ?>
                <?php
                /**
                 * Fires after the HTML-formatted 'must log in after' message in the comment form.
                 *
                 * @since 3.0.0
                 */
                do_action( 'comment_form_must_log_in_after' );
                ?>
            <?php else : ?>
                <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?>>
                    <?php
                    /**
                     * Fires at the top of the comment form, inside the <form> tag.
                     *
                     * @since 3.0.0
                     */
                    do_action( 'comment_form_top' );
                    ?>
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php
                        /**
                         * Filter the 'logged in' message for the comment form for display.
                         *
                         * @since 3.0.0
                         *
                         * @param string $args['logged_in_as'] The logged-in-as HTML-formatted message.
                         * @param array  $commenter            An array containing the comment author's username, email, and URL.
                         * @param string $user_identity        If the commenter is a registered user, the display name, blank otherwise.
                         */
                        echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
                        ?>
                        <?php
                        /**
                         * Fires after the is_user_logged_in() check in the comment form.
                         *
                         * @since 3.0.0
                         *
                         * @param array  $commenter     An array containing the comment author's username, email, and URL.
                         * @param string $user_identity If the commenter is a registered user, the display name, blank otherwise.
                         */
                        do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
                        ?>
                    <?php else : ?>
                        <?php echo $args['comment_notes_before']; ?>
                        <?php
                        /**
                         * Fires before the comment fields in the comment form.
                         *
                         * @since 3.0.0
                         */
                        do_action( 'comment_form_before_fields' );
                        foreach ( (array) $args['fields'] as $name => $field ) {
                            /**
                             * Filter a comment form field for display.
                             *
                             * The dynamic portion of the filter hook, $name, refers to the name
                             * of the comment form field. Such as 'author', 'email', or 'url'.
                             *
                             * @since 3.0.0
                             *
                             * @param string $field The HTML-formatted output of the comment form field.
                             */
                            echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                        }
                        /**
                         * Fires after the comment fields in the comment form.
                         *
                         * @since 3.0.0
                         */
                        do_action( 'comment_form_after_fields' );
                        ?>
                    <?php endif; ?>
                    <?php
                    /**
                     * Filter the content of the comment textarea field for display.
                     *
                     * @since 3.0.0
                     *
                     * @param string $args['comment_field'] The content of the comment textarea field.
                     */
                    echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
                    ?>
                    <?php echo $args['comment_notes_after']; ?>
                    <p class="form-submit">
                        <input class="btn btn-primary" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                        <?php comment_id_fields( $post_id ); ?>
                    </p>
                    <?php
                    /**
                     * Fires at the bottom of the comment form, inside the closing </form> tag.
                     *
                     * @since 1.5.0
                     *
                     * @param int $post_id The post ID.
                     */
                    do_action( 'comment_form', $post_id );
                    ?>
                </form>
            <?php endif; ?>
        </div><!-- #respond -->
        <?php
        /**
         * Fires after the comment form.
         *
         * @since 3.0.0
         */
        do_action( 'comment_form_after' );
    else :
        /**
         * Fires after the comment form if comments are closed.
         *
         * @since 3.0.0
         */
        do_action( 'comment_form_comments_closed' );
    endif;
}


/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own aviators_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function aviators_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            // Display trackbacks differently than normal comments.
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <p><?php _e( 'Pingback:', 'aviators' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'aviators' ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
            break;
        default :
            // Proceed with normal comments.
            global $post;
            ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <div class="comment-body">
                        <div class="row">
                        <div class="col-sm-2">
                            <header class="comment-meta comment-author vcard">
                                <?php
                                echo get_avatar( $comment, 130 );
                                ?>
                            </header><!-- .comment-meta -->
                        </div>

                        <div class="col-sm-10">
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="alert alert-warning comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'aviators' ); ?></p>
                            <?php endif; ?>

                            <section class="comment-content comment">
                                <div class="comment-meta">
                                    <?php
                                    printf( '<h3>%1$s</h3> %2$s',
                                        get_comment_author_link(),
                                        // If current post author is also comment author, make it known visually.
                                        ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'aviators' ) . '</span>' : ''
                                    );
                                    ?>

                                    <?php
                                    printf( '<div class="date"><i class="fa fa-calendar"></i><time datetime="%1$s">%2$s</time></div>',
                                        get_comment_time( 'c' ),
                                        /* translators: 1: date, 2: time */
                                        sprintf( __( '%1$s at %2$s', 'aviators' ), get_comment_date(), get_comment_time() )
                                    );
                                    ?>
                                </div>
                                <?php comment_text(); ?>
                                <?php edit_comment_link( __( 'Edit', 'aviators' ), '<p class="edit-link">', '</p>' ); ?>
                            </section><!-- .comment-content -->

                            <div class="reply">
                                <div class="btn btn-primary">
                                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'aviators' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                </div>
                            </div><!-- .reply -->
                        </div>
                        </div>
                    </div>
                </article><!-- #comment-## -->
            <?php
            break;
    endswitch; // end comment_type check
}
